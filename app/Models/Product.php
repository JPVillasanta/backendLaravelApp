<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    /*
     * Only these fields may be saved through Product::create() or update().
     * Add a field here when you add a matching database column.
     */
    protected $fillable = [
        'name',
        'description',
        'price',
        'quantity',
    ];

    protected function casts(): array
    {
        return [
            'price' => 'decimal:2',
            'quantity' => 'integer',
        ];
    }
}
