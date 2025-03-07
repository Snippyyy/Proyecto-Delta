<?php

namespace App\Policies;

use App\Models\Product;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function create(User $user): bool
    {
        return auth()->check();
    }

    public function update(User $user, Product $product): bool
    {
        return $user->id === $product->seller_id;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->seller_id;
    }

    public function restore(User $user, Product $product): bool
    {
        return $user->id === $product->seller_id;
    }

    public function forceDelete(User $user, Product $product): bool
    {
        return $user->id === $product->seller_id;
    }
}
