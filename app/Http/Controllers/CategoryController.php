<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

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
        Category::create($request->validated());

        return redirect()->route('category.index')->with('status', 'Categoria creada');
    }

    public function show(Category $category){
        return view('category.show', compact('category'));
    }
    public function destroy(Category $category){
        $category->delete();
        return redirect()->route('category.index')->with('status', 'Categoria eliminada');
    }

    public function edit(Category $category){
        return view('category.edit', compact('category'));
    }
    public function update(CategoryRequest $request, Category $category){
        $category->update($request->validated());
        return redirect()->route('category.show',$category)->with('status', 'Categoria Actualizada');
    }
}
