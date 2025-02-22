<?php

namespace App\View\Components;

use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class UserIndex extends Component
{
    public $users;

    public function __construct()
    {
        $this->users = User::select('name', 'avatar', 'province', 'address', 'postal_code')->get();
    }
    public function render(): View
    {
        return view('components.user-index');
    }
}
