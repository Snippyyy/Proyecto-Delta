<?php

namespace App\Http\Resources;

use App\Models\DiscountCode;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin DiscountCode */
class DiscountCodeResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'code' => $this->code,
            'discount' => $this->percentage . ' %',
            'status' => $this->is_active ? 'Inactivo' : 'Activo',
            'valid_until' => $this->valid_until,
        ];
    }
}
