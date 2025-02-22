<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

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

    public function shipment(Order $order, Request $request){

        $request->validate([
            'shipment_number' => 'required | string |min:5'
        ]);

        $order->shipment_number = $request->shipment_number;
        $order->save();
        return redirect()->route('my-sold.show', $order)->with('status', __("Número de seguimiento guardado"));
    }
}
