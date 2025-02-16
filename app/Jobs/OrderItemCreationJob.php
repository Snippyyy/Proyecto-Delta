<?php

namespace App\Jobs;

use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\SellerCart;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class OrderItemCreationJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Order $order;
    protected SellerCart $cart;

    public function __construct(Order $order, SellerCart $cart)
    {
        $this->order = $order;
        $this->cart = $cart;
    }

    public function handle(): void
    {
        $productIds = $this->cart->cart_items()->pluck('product_id');
        $products = Product::whereIn('id', $productIds)->get();

        foreach ($products as $product) {
            $orderItem = new OrderItem();
            $orderItem->order_id = $this->order->id;
            $orderItem->product_id = $product->id;
            $orderItem->save();
        }
    }
}
