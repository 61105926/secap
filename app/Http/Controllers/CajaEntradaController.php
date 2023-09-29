<?php

namespace App\Http\Controllers;

use App\Models\CajaEntrada;
use App\Http\Requests\StoreCajaEntradaRequest;
use App\Http\Requests\UpdateCajaEntradaRequest;
use App\Models\Caja;
use Illuminate\Http\Request;

class CajaEntradaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
    }
    public function create()
    {
    }
    public function store(Request $request)
    {
        $caja  = new CajaEntrada($request->all());
        $caja->caja_id = $request->input('caja_id');
        $caja->type = 'Caja';
        $caja->monto = $request->input('monto');
        $caja->description = $request->input('description');
        $caja->created_at = date('Y-m-d H:i:s');
        $caja->save();
        $cajaModelo = Caja::find($caja->caja_id);
        $cajaModelo->calculteEntradasSaldias();
        return redirect()->route('caja.index');
    }
    public function show($id)
    {
    }

    public function edit($id)
    {
    }
    public function update(Request $request, $id)
    {
        $caja = Caja::find($id);
        $caja->state = 1;
        $caja->updated_at = date('Y-m-d H:i:s');
        $caja->save();
        return redirect()->route('caja.index');
    }


    public function destroy($id)
    {
        //
    }
}
