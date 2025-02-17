<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodeRequest;
use App\Http\Resources\DiscountCodeResource;
use App\Models\DiscountCode;

class DiscountCodeController extends Controller
{
    public function index()
    {

        $discountCodes = DiscountCode::all();

        if ($discountCodes->isEmpty()) {
            return response()->json(['message' => 'No hay códigos de descuento registrados']);
        }

        return DiscountCodeResource::collection($discountCodes);
    }

    public function store(DiscountCodeRequest $request)
    {
        $data = $request->validated();

        $discountCode = DiscountCode::create($data);

        return response()->json([
            'message' => 'Código de descuento creado',
            new DiscountCodeResource($discountCode)
        ]);
    }

    public function show(DiscountCode $discountCode)
    {
        return new DiscountCodeResource($discountCode);
    }

    public function destroy(DiscountCode $discountCode)
    {
        $discountCode->delete();
        return response()->json(['message' => 'Código de descuento eliminado']);
    }

    public function activate(DiscountCode $discountCode)
    {
        $discountCode->is_active = true;
        $discountCode->save();
        return response()->json(['message' => 'Código de descuento activado', new DiscountCodeResource($discountCode)]);
    }

    public function deactivate(DiscountCode $discountCode)
    {
        $discountCode->is_active = false;
        $discountCode->save();
        return response()->json(['message' => 'Código de descuento desactivado', new DiscountCodeResource($discountCode)]);
    }
}
