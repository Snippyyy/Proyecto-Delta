<?php

namespace App\Http\Resources;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Product */
class ProductResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'seller' => $this->user->name,
            'category' => $this->category->name,
            'id' => $this->id,
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price / 100,
            'shipment' => $this->shipment ? 'Envío disponible' : 'Envío no disponible',
            'status' => $this->status === 'sold' ? 'Vendido' : ($this->status === 'published' ? 'Publicado' : 'Pendiente'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
