<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\FavoriteProducts;

class FavoriteItems extends Component
{
    public $favorite;
    public $showInput = false;
    public $note = '';
    public $isDeleted = false;

    public function mount($favorite)
    {
        $this->favorite = $favorite;
        $this->note = $favorite->note;
    }

    public function toggleInput()
    {
        $this->showInput = !$this->showInput;
    }

    public function saveNote()
    {
        $this->favorite->note = $this->note;
        $this->favorite->save();
        $this->showInput = false;
    }

    public function removeFavorite($favoriteId)
    {
        $favorite = FavoriteProducts::find($favoriteId);
        if ($favorite) {
            $favorite->delete();
            $this->isDeleted = true;
        }
    }
    public function render()
    {
        return view('livewire.favorite-items');
    }
}
