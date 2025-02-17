<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryProductsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'category' => $this->category->name,
            'id' => $this->id,
            'name' => $this->name,
        ];
    }
}
