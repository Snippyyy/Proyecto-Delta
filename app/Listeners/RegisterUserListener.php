<?php

namespace App\Listeners;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Mail\WelcomeMail;
use App\Models\SellerCart;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use App\Events\RegisterUserEvent;

class RegisterUserListener
{
    public SellerCart $cart;

    public function __construct()
    {
        $this->cart = SellerCart::where(['token' => request()->cookie('guest_cart_token')])->first();
    }

    public function handle(RegisterUserEvent $event): void
    {
        if ($this->cart) {
            $this->cart->token = null;
            $this->cart->user_id = $event->user->id;
            $this->cart->save();
        }
        \Mail::to($event->user->email)->queue((new WelcomeMail($event->user->name))->onQueue('emails'));
    }
}
