<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class CategoryController extends Controller
{
    use AuthorizesRequests;

    public function index(){
        $this->authorize('viewAny', Category::class);
        $categories = Category::all();
        return view('category.index', compact('categories'));
    }
    public function create(){
        $this->authorize('create', Category::class);
        return view('category.create');
    }

    public function store(CategoryRequest $request){
        $this->authorize('create', Category::class);
        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            Category::create($validated);
            return redirect()->route('categories')->with('status', __('Categoria creada'));
        }else{
            Category::create($request->validated());
            return redirect()->route('categories')->with('status', __(('Categoria creada')));
        }

    }
    public function show(Category $category){
        $categories = Category::all();
        $products = Product::publishedWithCategory($category->id)->get();
        return view('category.show', compact('category','products', 'categories'));
    }
    public function destroy(Category $category){
        $this->authorize('delete', $category);
        $category->delete();
        return redirect()->route('categories')->with('status', __('Categoria eliminada'));
    }

    public function edit(Category $category){
        $this->authorize('update', $category);
        return view('category.edit', compact('category'));
    }
    public function update(CategoryRequest $request, Category $category){

        $this->authorize('update', $category);

        if ($request->hasFile('icon')) {
            $path = $request->file('icon')->store('icons', 'public');
            $validated = $request->validated();
            $validated['icon'] = $path;
            $category->update($validated);
            return redirect()->route('category.show',$category)->with('status', __('Categoria Actualizada'));
        }else{
        $category->update($request->validated());
        return redirect()->route('category.show',$category)->with('status', __('Categoria Actualizada'));
        }
    }
}
