<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Product extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_category',
        'categorias',
        'price',
        'discount',
        'stock',
        'image',
    ];

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categoria::class, 'id_category');
    }
}
