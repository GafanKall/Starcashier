<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Product;

class Admin extends Controller
{
    public function index () {
        return view('admin.index');
    }

    public function Total()
    {
        $users = User::all();
        $products = Product::all();
        return view('admin.index', compact('users', 'products'));
    }


}
