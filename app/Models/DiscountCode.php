<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DiscountCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'percentage',
        'valid_until',
        'is_active',
    ];

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper($value);
    }

    public function sellerCarts(): HasMany
    {
        return $this->hasMany(SellerCart::class);
    }
}
