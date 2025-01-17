<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'shipment',
    ];

    public function user(): BelongsTo {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }
    public function category(): BelongsTo {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function productImages(): HasMany {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

public function cart_items(): HasMany {
    return $this->hasMany(CartItem::class, 'product_id', 'id');
}
}
