<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\Departament;

class Client extends Model
{
    use HasFactory;
    protected $guarded = [];
    // uno a muchos-inversa

    public function departament(): BelongsTo
    {
        return $this->belongsTo(Departament::class, 'id_departament');
    }
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
}
