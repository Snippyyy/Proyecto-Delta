<?php

namespace App\Livewire;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use App\Models\DiscountCode;

class DiscountCodes extends Component
{
    use AuthorizesRequests;

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
        $this->authorize('toggle', DiscountCode::class);

        $code = DiscountCode::findOrFail($id);
        $code->is_active = !$code->is_active;
        $code->save();

        $this->loadDiscountCodes();

        $this->dispatch('refreshDiscountCodes');
    }

    public function deleteCode($id)
    {
        $this->authorize('delete', DiscountCode::class);
        $code = DiscountCode::findOrFail($id);

        $carts = $code->sellerCarts;

        foreach ($carts as $cart) {
            $cart->discount_code_id = null;
            $cart->discount_price = 0;
            $cart->save();
        }

        $code->delete();

        $this->loadDiscountCodes();

        $this->dispatch('refreshDiscountCodes');
    }
    public function render()
    {
        return view('livewire.discount-codes');
    }
}
