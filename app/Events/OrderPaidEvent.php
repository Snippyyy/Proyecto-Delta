<?php

namespace App\Events;

use Illuminate\Foundation\Events\Dispatchable;
use App\Models\Order;
use Illuminate\Queue\SerializesModels;

class OrderPaidEvent
{
    use Dispatchable;
    public Order $order;
    public function __construct(Order $order)
    {
        $this->order = $order;
    }
}
