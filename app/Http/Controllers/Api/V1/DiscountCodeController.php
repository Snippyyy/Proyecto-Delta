<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\DiscountCodeRequest;
use App\Http\Resources\DiscountCodeResource;
use App\Models\DiscountCode;

class DiscountCodeController extends Controller
{
    /**
     * @group Códigos de Descuento
     *
     * Obtener todos los códigos de descuento
     *
     * Este endpoint recupera todos los códigos de descuento registrados.
     *
     * @response 200 {
     *  "data": [
     *    {
     *      "id": 1,
     *      "code": "DESCUENTO10",
     *      "discount": 10,
     *      "is_active": true,
     *      "created_at": "2023-01-01T00:00:00.000000Z",
     *      "updated_at": "2023-01-01T00:00:00.000000Z"
     *    }
     *  ]
     * }
     * @response 404 {
     *  "message": "No hay códigos de descuento registrados"
     * }
     */
    public function index()
    {
        $discountCodes = DiscountCode::all();

        if ($discountCodes->isEmpty()) {
            return response()->json(['message' => 'No hay códigos de descuento registrados'], 404);
        }

        return DiscountCodeResource::collection($discountCodes);
    }

    /**
     * @group Códigos de Descuento
     *
     * Crear un nuevo código de descuento
     *
     * Este endpoint permite crear un nuevo código de descuento.
     *
     * @bodyParam code string required El código de descuento. Ejemplo: "DESCUENTO10"
     * @bodyParam discount int required El porcentaje de descuento. Ejemplo: 10
     * @bodyParam is_active boolean Indica si el código de descuento está activo. Ejemplo: true
     *
     * @response 201 {
     *  "message": "Código de descuento creado",
     *  "data": {
     *    "id": 1,
     *    "code": "DESCUENTO10",
     *    "discount": 10,
     *    "is_active": true,
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function store(DiscountCodeRequest $request)
    {
        $data = $request->validated();

        $discountCode = DiscountCode::create($data);

        return response()->json([
            'message' => 'Código de descuento creado',
            new DiscountCodeResource($discountCode)
        ], 201);
    }

    /**
     * @group Códigos de Descuento
     *
     * Obtener un código de descuento
     *
     * Este endpoint recupera un código de descuento específico.
     *
     * @response 200 {
     *  "data": {
     *    "id": 1,
     *    "code": "DESCUENTO10",
     *    "discount": 10,
     *    "is_active": true,
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function show(DiscountCode $discountCode)
    {
        return new DiscountCodeResource($discountCode);
    }

    /**
     * @group Códigos de Descuento
     *
     * Eliminar un código de descuento
     *
     * Este endpoint permite eliminar un código de descuento existente.
     *
     * @response 200 {
     *  "message": "Código de descuento eliminado"
     * }
     */
    public function destroy(DiscountCode $discountCode)
    {
        $discountCode->delete();
        return response()->json(['message' => 'Código de descuento eliminado']);
    }

    /**
     * @group Códigos de Descuento
     *
     * Activar un código de descuento
     *
     * Este endpoint permite activar un código de descuento.
     *
     * @response 200 {
     *  "message": "Código de descuento activado",
     *  "data": {
     *    "id": 1,
     *    "code": "DESCUENTO10",
     *    "discount": 10,
     *    "is_active": true,
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function activate(DiscountCode $discountCode)
    {
        $discountCode->is_active = true;
        $discountCode->save();
        return response()->json(['message' => 'Código de descuento activado', new DiscountCodeResource($discountCode)]);
    }

    /**
     * @group Códigos de Descuento
     *
     * Desactivar un código de descuento
     *
     * Este endpoint permite desactivar un código de descuento.
     *
     * @response 200 {
     *  "message": "Código de descuento desactivado",
     *  "data": {
     *    "id": 1,
     *    "code": "DESCUENTO10",
     *    "discount": 10,
     *    "is_active": false,
     *    "created_at": "2023-01-01T00:00:00.000000Z",
     *    "updated_at": "2023-01-01T00:00:00.000000Z"
     *  }
     * }
     */
    public function deactivate(DiscountCode $discountCode)
    {
        $discountCode->is_active = false;
        $discountCode->save();
        return response()->json(['message' => 'Código de descuento desactivado', new DiscountCodeResource($discountCode)]);
    }
}
