<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class CreateProduct extends Controller
{
    public function index()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('petugas.index', ['products' => $products], ['categories' => $categories]);
    }

    public function second()
    {
        $products = Product::all();
        $categories = Category::all();
        return view('petugas.product', ['products' => $products], ['categories' => $categories]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('petugas.product', ['categories' => $categories]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'image' => 'required|image',
            'product_name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'categories_id' => 'required|exists:categories,id',
        ]);

        $path = $request->file('image')->store('public/images');
        $validated['image'] = $path;

        Product::create($validated);

        return redirect()->route('petugas.product')->with('success', 'Product created successfully.');
    }

    public function edit(Product $product)
    {
        $products = Product::all();
        $categories = Category::all();
        return view('petugas.product', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'image' => 'nullable|image',
            'product_name' => 'required|string|max:255',
            'price' => 'required|integer',
            'stock' => 'required|integer',
            'categories_id' => 'required|exists:categories,id',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');
            $validated['image'] = $path;
        }

        $product->update($validated);

        return redirect()->route('petugas.product')->with('success', 'Product updated successfully.');
    }

    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('petugas.product')->with('success', 'Product deleted successfully.');
    }

    public function decreaseStock(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');

        // Check if there is enough stock
        if ($product->stock >= $quantity) {
            $product->stock -= $quantity;
            $product->save();

            return response()->json(['success' => true, 'stock' => $product->stock]);
        }

        return response()->json(['success' => false, 'message' => 'Insufficient stock']);
    }

    public function increaseStock(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');

        // Tambahkan stok
        $product->stock += $quantity;
        $product->save();

        return response()->json(['success' => true, 'stock' => $product->stock]);
    }

    public function updateStock(Request $request, Product $product)
    {
        $quantity = $request->input('quantity');

        // Wrap stock update in a transaction to avoid race conditions
        \DB::transaction(function () use ($product, $quantity) {
            if ($product->stock >= $quantity) {
                $product->stock -= $quantity;
                $product->save();
                return response()->json(['success' => true, 'stock' => $product->stock]);
            }
            return response()->json(['success' => false, 'message' => 'Insufficient stock']);
        });
    }


    public function getProducts() {
        $products = Product::all(); // Mengambil semua produk
        return response()->json($products);
    }

}
