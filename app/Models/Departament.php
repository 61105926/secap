<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use App\Models\Client;

class Departament extends Model
{
    use HasFactory;
    protected $guarded = [];
    // uno a muchos
    public function client(): HasMany
    {
        return $this->hasMany(Client::class);
    }
}
