<?php

use App\Http\Controllers\TransactionController;
use App\Http\Controllers\CreateCategory;
use App\Http\Controllers\CreatePetugas;
use App\Http\Controllers\CreateProduct;
use App\Http\Controllers\LandingPage;
use App\Http\Controllers\Admin;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('landing.index');
});

// Login
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login', [AuthController::class, 'auth'])->name('login.auth');

// Register
Route::get('/register', [AuthController::class, 'index'])->name('register');
Route::post('/register', [AuthController::class, 'store'])->name('register.store');

// Logout
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('landing');
})->name('logout');


Route::get('/landing', [LandingPage::class, 'index'])->name('landing');

// Admin Routing
Route::get('/admin/home', [Admin::class, 'index'])->name('admin');
Route::resource('/admin/petugas', CreatePetugas::class);
Route::get('/admin/home', [Admin::class, 'Total'])->name('admin.home');
Route::get('/admin/petugas', [CreatePetugas::class, 'index'])->name('admin.petugas');
Route::get('/admin/petugas/{id}/edit', [CreatePetugas::class, 'edit'])->name('edituserpetugas');
Route::put('/admin/petugas', [CreatePetugas::class, 'update'])->name('updateuserpetugas');


// Petugas Routing
Route::get('/petugas/home', [CreateProduct::class, 'index'])->name('petugas');
Route::get('/petugas/product', [CreateProduct::class, 'second'])->name('petugas.product');
Route::get('/petugas/category', [CreateCategory::class, 'index'])->name('petugas.category');

Route::post('/petugas/product', [CreateProduct::class, 'store'])->name('petugas.product.store');
Route::get('/petugas/product/{product}/edit', [CreateProduct::class, 'edit'])->name('petugas.product.edit');
Route::delete('/petugas/product/{product}', [CreateProduct::class, 'destroy'])->name('petugas.product.destroy');
Route::put('/petugas/product/{product}', [CreateProduct::class, 'update'])->name('petugas.product.update');
Route::post('/product/decrease-stock/{product}', [CreateProduct::class, 'decreaseStock'])->name('product.decreaseStock');
Route::post('/product/decrease-stock/{product}', [CreateProduct::class, 'decreaseStock']);
Route::post('/product/increase-stock/{product}', [CreateProduct::class, 'increaseStock']);

Route::post('/petugas/category', [CreateCategory::class, 'create'])->name('petugas.category.create');
Route::post('/petugas/category', [CreateCategory::class, 'store'])->name('petugas.category.store');
Route::get('/petugas/category/{category}/edit', [CreateCategory::class, 'edit'])->name('petugas.category.edit');
Route::put('/petugas/category/{category}', [CreateCategory::class, 'update'])->name('petugas.category.update');
Route::delete('/petugas/category/{category}', [CreateCategory::class, 'destroy'])->name('petugas.category.destroy');


Route::post('/submit-transaction', [TransactionController::class, 'submitTransaction'])->name('transaction.submit');
