<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pay extends Model
{
    use HasFactory;
    protected $fillable =
    [
        'id_user',
        'id_venta',
        'type_transfer',
        'amount',
        'created_at',
        'updated_at',
    ];
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
