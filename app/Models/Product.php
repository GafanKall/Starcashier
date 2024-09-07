<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['image', 'product_name', 'price', 'stock', 'categories_id'];

    // Definisi relasi dengan Category
    public function category()
    {
        return $this->belongsTo(Category::class, 'categories_id');
    }
}


