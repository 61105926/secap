<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Venta extends Model
{
    use HasFactory;
    protected $table = "ventas";
    protected $fillable =
    [
        'id_user',
        'id_client',
        'subtotal',
        'id_product',
        'extra',
        'total_price',
        'discount',
        'balance',
        'description',
    ];


    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class, 'id_client');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function product(): BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }
    public function pay(): HasMany
    {
        return $this->hasMany(Pay::class);
    }
    
    
}
