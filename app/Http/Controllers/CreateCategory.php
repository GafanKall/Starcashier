<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CreateCategory extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('petugas.category', ['categories' => $categories]);
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
        $category = Category::find($id); // Ensure we find the category by ID
        if (!$category) {
            return redirect()->route('petugas.category')->with('error', 'Category not found!');
        }

        return response()->json($category); // Use JSON response for fetching data in JavaScript
    }

    // Update function to save the edited category
    public function update(Request $request, $id)
    {
        $request->validate([
            'category_name' => 'required|string|max:255',
        ]);

        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('petugas.category')->with('error', 'Category not found!');
        }

        $category->update([
            'category_name' => $request->category_name,
        ]);

        return redirect()->route('petugas.category')->with('success', 'Category updated successfully!');
    }

    // Destroy function to delete the category
    public function destroy($id)
    {
        $category = Category::find($id);
        if (!$category) {
            return redirect()->route('petugas.category')->with('error', 'Category not found!');
        }

        $category->delete();
        return redirect()->route('petugas.category')->with('success', 'Category deleted successfully!');
    }
}
