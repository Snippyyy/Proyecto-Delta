<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;

class CategoryController extends Controller
{

    public function index(){
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }
    public function create(){
        return view('category.create');
    }

    public function store(CategoryRequest $request){
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            Category::create($validated);
            return redirect()->route('categories')->with('status', 'Categoria creada');
        }else{
            Category::create($request->validated());
            return redirect()->route('categories')->with('status', 'Categoria creada');
        }

    }
    public function show(Category $category){
        $categories = Category::all();
        $products = Product::publishedWithCategory($category->id)->get();
        return view('category.show', compact('category',['products','categories']));
    }
    public function destroy(Category $category){
        $category->delete();
        return redirect()->route('categories')->with('status', 'Categoria eliminada');
    }

    public function edit(Category $category){
        return view('category.edit', compact('category'));
    }
    public function update(CategoryRequest $request, Category $category){
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            $category->update($validated);
            return redirect()->route('category.show',$category)->with('status', 'Categoria Actualizada');
        }else{
        $category->update($request->validated());
        return redirect()->route('category.show',$category)->with('status', 'Categoria Actualizada');
        }
    }
}
