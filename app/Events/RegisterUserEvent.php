<?php

namespace App\Events;

use App\Models\User;
use Illuminate\Foundation\Events\Dispatchable;

class RegisterUserEvent
{
    use Dispatchable;

    public $name;
    public $email;

    public function __construct(User $user)
    {
        $this->name = $user->name;
        $this->email = $user->email;
    }
}
