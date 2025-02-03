<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;

class UserSoldController extends Controller
{
    public function index()
    {
        $orders = Order::where('seller_id', auth()->id())->get();


        return view('profile.solds.my-solds', compact('orders'));
    }

    public function show(Order $order){
        $orderItems = OrderItem::where('order_id', $order->id)->get();
        return view('profile.solds.my-solds-show', compact('order', 'orderItems'));
    }
}
