<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\SellerCart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;


class OrderCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected SellerCart $cart;
    protected string $sessionId;

    public function __construct(SellerCart $cart, $sessionId)
    {
        $this->cart = $cart;
        $this->sessionId = $sessionId;
    }

    public function handle(): void
    {

        $order = new Order();
        $order->status = 'unpaid';
        $order->total_price = $this->cart->total_price;
        $order->session_id = $this->sessionId;
        $order->buyer_id = $this->cart->user_id;
        $order->seller_id = $this->cart->seller_id;
        if ($this->cart->discount_code){
            $order->total_price = $this->cart->discount_price;
        }else{
            $order->total_price = $this->cart->total_price;
        }
        $order->save();
        OrderItemCreationJob::dispatch($order, $this->cart);
    }
}
