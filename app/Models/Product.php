<?php

namespace App\Models;

use App\Observers\ProductModifiedObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


#[ObservedBy(ProductModifiedObserver::class)]
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

    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePublishedWithCategory($query, $categoryId)
    {
        return $query->where('status', 'published')
            ->where('category_id', $categoryId);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id', 'id');
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function productImages(): HasMany
    {
        return $this->hasMany(ProductImage::class, 'product_id', 'id');
    }

    public function cart_items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'product_id', 'id');
    }

    public function order_items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'product_id', 'id');
    }
}
