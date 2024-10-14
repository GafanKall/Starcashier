<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'cashier_id',
        'total_amount',
        'done',
    ];

    /**
     * Relasi ke model User (cashier).
     */
    // public function cashier()
    // {
    //     return $this->belongsTo(User::class, 'cashier_id');
    // }

    /**
     * Relasi ke model DetailTransaction.
     */
    public function details()
    {
        return $this->hasMany(DetailTransaction::class);
    }
}
