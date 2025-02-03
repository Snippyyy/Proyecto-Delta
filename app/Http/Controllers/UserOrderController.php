<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class UserOrderController extends Controller
{
    public function index()
    {
        $orders = Order::where('buyer_id', auth()->id())->get();


        return view('profile.orders.my-orders', compact('orders'));
    }

    public function show(Order $order){
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        return view('profile.orders.my-orders-show', compact('order', 'orderItems'));
    }
}
