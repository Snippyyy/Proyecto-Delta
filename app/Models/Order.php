<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use function PHPUnit\Framework\returnSelf;

class Order extends Model
{
    protected $table = 'orders';
    use HasFactory;

    protected $fillable = [
        'status',
        'buyer_id',
        'seller_id',
        'total_price',
        'session_id',
        'shipment_number',
    ];

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function buyer_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'buyer_id');
    }

    public function seller_user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'seller_id');
    }
}
