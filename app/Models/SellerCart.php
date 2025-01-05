<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SellerCart extends Model
{
    protected $fillable = ['user_id', 'seller_id', 'quantity', 'total_price'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function cart_items(): HasMany
    {
        return $this->hasMany(Cart_item::class);
    }

    public function seller(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }

}
