<?php

namespace App\Livewire;

use App\Models\Product;
use Livewire\Component;

class ProductItem extends Component
{
    public Product $product;
    public function render()
    {
        return view('livewire.product-item');
    }

    public function mount(Product $product)
    {
        $this->product = $product;
    }

    public function toggleFavorite()
    {
        if ($this->product->user->id == auth()->id()) {
            return;
        }

        $user = auth()->user();
        if ($user->favoriteProducts()->where('product_id', $this->product->id)->exists()) {
            $user->favoriteProducts()->detach($this->product->id);
        } else {
            $user->favoriteProducts()->attach($this->product->id);
        }
    }
}
