<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin User */
class UserProfileResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'province' => $this->province,
            'address' => $this->address,
            'postal_code' => $this->postal_code,
            'phone_number' => $this->phone_number,
            'products' => ProductsResource::collection($this->products),
            'comments' => CommentsResource::collection($this->comments),
        ];
    }
}
