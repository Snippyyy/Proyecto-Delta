<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountCodeRequest;
use App\Models\DiscountCode;

class DiscountCodeController extends Controller
{
    public function index()
    {

        $discountCodes = DiscountCode::all();

        return view('discount-code.discount-index', compact('discountCodes'));
    }

    public function create()
    {
        return view('discount-code.discount-create');
    }

    public function store(DiscountCodeRequest $request)
    {
        $data = $request->validated();

        DiscountCode::create($data);

        return redirect()->route('discount-code');
    }
}
