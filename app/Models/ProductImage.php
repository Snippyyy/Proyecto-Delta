<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProductImage extends Model
{
    protected $table = 'product_images';
    protected $fillable = [
        'product_id',
        'img_path',
        'order',
    ];

    public function product(): BelongsTo {
        return $this->belongsTo(Product::class, 'product_id');
    }
}