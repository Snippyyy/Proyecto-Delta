<?php

namespace App\Http\Resources;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/** @mixin Comment */
class CommentsResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'user' => $this->buyer->name,
            'comment' => $this->comment,
        ];
    }
}
