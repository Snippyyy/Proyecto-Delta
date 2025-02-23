<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
    use HasRoles;
    use HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'avatar',
        'province',
        'address',
        'postal_code',
        'phone_number',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function products(): HasMany{
        return $this->hasMany(Product::class, 'seller_id', 'id');
    }

    public function sellerCarts(): HasMany{
        return $this->HasMany(SellerCart::class);
    }

    public function orders(): HasMany{
        return $this->hasMany(Order::class, 'buyer_id', 'id');
    }

    public function comments(): HasMany{
        return $this->hasMany(Comment::class);
    }

    public function favoriteProducts(): BelongsToMany {
        return $this->belongsToMany(Product::class, 'favorites')->withTimestamps();
    }


}
