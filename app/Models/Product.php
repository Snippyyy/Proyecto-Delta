<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
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
}