<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CreateCategory extends Controller
{
    public function index()
    {
        $categorys = Category::all();
        return view('petugas.category', ['categorys' => $categorys]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        Category::create([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('petugas.category')->with('success', 'Category added successfully!');
    }

    public function edit($id)
    {
        $categorys = Category::find($id);
        return view('petugas.category-edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);


        $categorys = Category::find($id);
        $categorys->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('petugas.category')->with('success', 'Category updated successfully!');
    }

    public function destroy($id)
    {
        Category::destroy($id);
        return redirect()->route('petugas.category')->with('success', 'Category deleted successfully!');
    }
}
