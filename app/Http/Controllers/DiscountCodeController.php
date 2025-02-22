<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountCodeRequest;
use App\Models\DiscountCode;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class DiscountCodeController extends Controller
{
    use AuthorizesRequests;
    public function index()
    {
        $this->authorize('viewAny', DiscountCode::class);
        return view('discount-code.discount-index');
    }

    public function create()
    {
        $this->authorize('create', DiscountCode::class);
        return view('discount-code.discount-create');
    }

    public function store(DiscountCodeRequest $request)
    {
        $this->authorize('create', DiscountCode::class);
        $data = $request->validated();

        DiscountCode::create($data);

        return redirect()->route('discount-code');
    }
}
