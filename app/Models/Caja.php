<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    use HasFactory;
    protected $fillable = [
        'user_id',
        'description',
        'state',
        'total_salida',
        'total_entrada',
        'total_entrada',

    ];
    public $timestamps = false;
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function cajasEntrada()
    {
        return $this->hasMany(CajaEntrada::class);
    }
    public function cajasOperaciones()
    {
        return $this->hasMany(CajaOperaciones::class);
    }
    public function cajasSalidaOperaciones()
    {
        return $this->hasMany(CajaSalidaOperaciones::class);
    }

    public function calculteEntradasSaldias()
    {
        $caTotal     = CajaEntrada::where('caja_id', '=', $this->id)->sum('monto');
        $csTotal     = CajaSalida::where('caja_id', '=', $this->id)->sum('monto');
        $coTotal     = CajaOperaciones::where('caja_id', '=', $this->id)->sum('monto');
        $cosTotal     = CajaSalidaOperaciones::where('caja_id', '=', $this->id)->sum('monto');
        $this->total_entrada = $caTotal;
        $this->total_salida = $csTotal;
        $this->total_operacion = $coTotal;
        $this->total_operacion_salida = $cosTotal;

        $this->save();
    }
}
