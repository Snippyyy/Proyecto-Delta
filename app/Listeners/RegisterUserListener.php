<?php

namespace App\Listeners;

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Mail\WelcomeMail;
use Illuminate\Auth\Events\Registered;
use App\Events\RegisterUserEvent;

class RegisterUserListener
{
    public function __construct()
    {
    }

    public function handle(RegisterUserEvent $event): void
    {
        \Mail::to($event->email)->queue((new WelcomeMail($event->name))->onQueue('emails'));
    }
}
