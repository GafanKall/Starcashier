<?php

// app/Http/Controllers/TransactionController.php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\DetailTransaction;
use App\Models\Product;

class TransactionController extends Controller
{
    public function submitTransaction(Request $request)
{

    // Decode JSON dari input 'products'
    $products = json_decode($request->input('products'), true);
    $totalAmount = $request->total_amount;
    $totalPayment = $request->total_payment;

    if (empty($products)) {
        return response()->json(['success' => false, 'message' => 'No products selected for the transaction!']);
    }

    $totalAmount = $request->input('total_amount');
    $transaction = Transaction::create([
        'date' => now(),
        'cashier_id' => auth()->id(),
        'total_amount' => $totalAmount,
        'done' => true,
    ]);

    foreach ($products as $product) {
        $productData = Product::find($product['id']);
        if (!$productData) {
            return response()->json(['success' => false, 'message' => 'Product not found!']);
        }

        DetailTransaction::create([
            'transaction_id' => $transaction->id,
            'product_id' => $productData->id,
            'quantity' => $product['quantity'],
        ]);

        // Update stock
        $productData->decrement('stock', $product['quantity']);
    }

    return response()->json(['success' => true, 'message' => 'Transaction completed successfully!']);
}



}
