<?php

namespace App\Http\Controllers;

use App\Events\OrderPaidEvent;
use App\Jobs\OrderCreationJob;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerCart;
use Stripe\Checkout\Session;

use Stripe\Customer;
use Stripe\Stripe;
use Stripe\StripeClient;
use Stripe\Webhook;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class StripeCheckoutController extends Controller
{
    public function session (SellerCart $cart)
    {

        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));


        $lineItems = [];
        $cartItems = CartItem::where('seller_cart_id', $cart->id)->get();
        $productIds = $cartItems->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get();


        if ($cart->discount_code){
            foreach ($products as $product) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->name,
                            'images' => [$product->productImages->first()->img_path],
                        ],
                        'unit_amount' => floor($product->price / $cart->total_price * $cart->discount_price), //Ajustar precio en el futuro
                    ],
                    'quantity' => 1,
                ];
            }
        }else{
            foreach ($products as $product) {
                $lineItems[] = [
                    'price_data' => [
                        'currency' => 'eur',
                        'product_data' => [
                            'name' => $product->name,
                            'images' => [$product->productImages->first()->img_path],
                        ],
                        'unit_amount' => $product->price,
                    ],
                    'quantity' => 1,
                ];
            }
        }
        $session = Session::create([
            'line_items' => $lineItems,
            'mode' => 'payment',
            'customer_email' => auth()->user()->email,
            'success_url' => route('cart.checkout.success', [$cart], true)."?session_id={CHECKOUT_SESSION_ID}",
            'cancel_url' =>route('cart.checkout.cancel', [$cart], true)."?session_id={CHECKOUT_SESSION_ID}",
        ]);
        OrderCreationJob::dispatch($cart, $session->id);


        return redirect($session->url);
    }

    public function success()
    {
        Stripe::setApiKey(env('STRIPE_SECRET_KEY'));

        $sessionId = request()->get('session_id');

        try {
            if (app()->environment('testing')) {
                $session = (object) ['id' => $sessionId, 'payment_status' => 'paid'];
            } else {
                $session = Session::retrieve($sessionId);
            }

            if (!$session) {
                throw new NotFoundHttpException('Session not found');
            }

            $order = Order::where('session_id', $sessionId)->first();
            if (!$order) {
                throw new NotFoundHttpException('Order not found');
            }

            if ($order->status === 'unpaid') {
                $order->status = 'paid';
                $order->save();
            }
            event(new OrderPaidEvent($order));

            return view('cart.checkout.success');
        } catch (\Exception $e) {
            \Log::error('Error processing session: ' . $e->getMessage());
            throw new NotFoundHttpException('Session not found');
        }
    }

    public function cancel()
    {

        $sessionId = request()->get('session_id');

        $order = Order::where('session_id', $sessionId)->first();

        if (!$order) {
            throw new NotFoundHttpException('Order not found');
        }

        $order->delete();

        return view('cart.checkout.cancel');
    }

    public function webhook(){


        $endpoint_secret = env('STRIPE_WEBHOOK_SECRET');

        $payload = @file_get_contents('php://input');
        $sig_header = $_SERVER['HTTP_STRIPE_SIGNATURE'];
        $event = null;

        try {
            $event = Webhook::constructEvent(
                $payload, $sig_header, $endpoint_secret
            );
        } catch(\UnexpectedValueException $e) {
            // Invalid payload
            http_response_code(400);
            exit();
        } catch(\Stripe\Exception\SignatureVerificationException $e) {
            // Invalid signature
            http_response_code(400);
            exit();
        }

        // Handle de eventos especificos

        switch ($event->type) {
            case 'payment_intent.succeeded':
                $session = $event->data->object; // Contiene un \Stripe\PaymentIntent
                $sessionId = $session->id;
                \Log::info('Session ID: ' . $sessionId);

                $order = Order::where('session_id', $sessionId)->first();

                //ENVIAR EMAIL

            default:
                // Evento desconocido
                echo 'Received unknown event type ' . $event->type;
                exit();
        }
        http_response_code(200);
    }
}
