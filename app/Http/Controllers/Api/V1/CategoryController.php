<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Http\Resources\CategoryProductsResource;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use App\Models\Product;
use http\Env\Response;

class CategoryController extends Controller
{

    public function index(){
        $categories = Category::all();
        return CategoryResource::collection($categories);
    }

    public function store(CategoryRequest $request){
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            Category::create($validated);
            return response()->json(['message' => 'Categoria creada']);
        }else{
            Category::create($request->validated());
            return response()->json(['message' => 'Categoria creada']);
        }
    }

    public function show(Category $category){
        $products = Product::publishedWithCategory($category->id)->get();
        return CategoryProductsResource::collection($products, $category->name);
    }

    public function destroy(Category $category){
        $category->delete();
        return response()->json(['message' => 'Categoria eliminada']);
    }

    public function update(CategoryRequest $request, Category $category){
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            $category->update($validated);
            return response()->json(['message' => 'Categoria Actualizada']);
        }else{
        $category->update($request->validated());
        return response()->json(['message' => 'Categoria Actualizada']);
        }
    }
}
