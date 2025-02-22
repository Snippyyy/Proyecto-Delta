<?php

namespace App\Policies;

use App\Models\DiscountCode;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiscountCodePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function toggle(User $user): bool
    {
        return $user->hasRole('admin');
    }
}
