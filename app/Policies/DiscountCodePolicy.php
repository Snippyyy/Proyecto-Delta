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
        return true;
    }

    public function view(User $user, DiscountCode $discountCode): bool
    {
        return true;
    }

    public function create(User $user): bool
    {
        return $user->hasRole('admin');
    }

    public function update(User $user, DiscountCode $discountCode): bool
    {
        return $user->hasRole('admin');
    }

    public function delete(User $user, DiscountCode $discountCode): bool
    {
        return $user->hasRole('admin');
    }

    public function restore(User $user, DiscountCode $discountCode): bool
    {
        return $user->hasRole('admin');
    }

    public function forceDelete(User $user, DiscountCode $discountCode): bool
    {
        return $user->hasRole('admin');
    }
}
