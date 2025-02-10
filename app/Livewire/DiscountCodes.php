<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\DiscountCode;

class DiscountCodes extends Component
{
    public $discountCodes;

    protected $listeners = ['refreshDiscountCodes' => 'loadDiscountCodes'];

    public function mount()
    {
        $this->loadDiscountCodes();
    }

    public function loadDiscountCodes()
    {
        $this->discountCodes = DiscountCode::orderBy('created_at', 'desc')->get();
    }

    public function toggleStatus($id)
    {
        $code = DiscountCode::findOrFail($id);
        $code->is_active = !$code->is_active;
        $code->save();

        $this->loadDiscountCodes();

        $this->dispatch('refreshDiscountCodes');
    }

    public function deleteCode($id)
    {
            $code = DiscountCode::findOrFail($id);
            $code->delete();

            $this->loadDiscountCodes();

            $this->dispatch('refreshDiscountCodes');
    }
    public function render()
    {
        return view('livewire.discount-codes');
    }
}
