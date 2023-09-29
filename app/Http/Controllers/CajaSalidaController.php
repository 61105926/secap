<?php

namespace App\Http\Controllers;

use App\Models\CajaSalida;
use App\Http\Requests\StoreCajaSalidaRequest;
use App\Http\Requests\UpdateCajaSalidaRequest;
use App\Models\Caja;
use Illuminate\Http\Request;

class CajaSalidaController extends Controller
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
        $caja  = new CajaSalida($request->all());
        $caja->caja_id = $request->input('caja_id');
        $caja->type = 'Caja';
        $caja->monto = $request->input('monto');
        $caja->description = $request->input('description');
        $caja->created_at = date('Y-m-d H:i:s');
        $caja->save();
        $cajaModelo = Caja::find($caja->caja_id);
        // dd($cajaModelo);
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
    }
    public function destroy($id)
    {
    }
}
