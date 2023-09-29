<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Http\Requests\StoreCajaRequest;
use App\Http\Requests\UpdateCajaRequest;
use App\Models\CajaEntrada;
use App\Models\CajaOperaciones;
use App\Models\CajaSalida;
use App\Models\CajaSalidaOperaciones;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;

class CajaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('cajero')) {
            $caja = Caja::all()->where('user_id', '=', Auth::user()->id);
            return view('caja.index', ['caja' => $caja]);
        } elseif (Auth::user()->hasRole('superadmin')) {
            $caja = Caja::all();
            return view('caja.index', ['caja' => $caja]);
        } elseif (Auth::user()->hasRole('admin')) {
            $caja = Caja::all();
            return view('caja.index', ['caja' => $caja]);
        }
    }
    public function create()
    {
        $find = Caja::latest('id')->first();
        // dd($find);
        if (is_null($find)) {
            $find = 0;
            return view('caja.create', ['find' => $find]);
        } else {
            $find = Caja::latest('id')->first();
            return view('caja.create', ['find' => $find->id]);
        }
    }
    public function store(StoreCajaRequest $request)
    {

        $caja  = new Caja($request->all());
        $caja->user_id = Auth::user()->id;
        $caja->state = 0;
        $caja->description = $request->input('description');
        $caja->created_at = date('Y-m-d H:i:s');
        $caja->save();
        $cajaModelo = Caja::find($caja->id);
        $cajaModelo->calculteEntradasSaldias();
        if (is_null($request->input('caja_id'))) {

            $caja  = new CajaEntrada($request->all());
            $caja->caja_id = 1;
            $caja->type = 'Caja';
            $caja->monto = $request->input('monto');
            $caja->description = $request->input('description');
            $caja->created_at = date('Y-m-d H:i:s');
            $caja->save();
            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();
            return redirect()->route('caja.index');
        } else {
            $caja  = new CajaEntrada($request->all());
            $caja->type = 'Caja';
            $caja->caja_id = $request->input('caja_id');
            $caja->monto = $request->input('monto');
            $caja->description = $request->input('description');
            $caja->created_at = date('Y-m-d H:i:s');
            $caja->save();

            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();

            return redirect()->route('caja.index');
        }
    }
    public function show(Caja $caja)
    {
        //
    }


    public function edit(Caja $caja)
    {
        // dd($caja->cajasEntrada()->where('caja_id', '=', $id)->get());
        $cajaEntrada = CajaEntrada::where('caja_id', '=', $caja->id)->get();
        $cajaSalida  = CajaSalida::where('caja_id', '=', $caja->id)->get();
        $cajaOperacion  = CajaOperaciones::where('caja_id', '=', $caja->id)->get();
        $cajaOperacionSalida  = CajaSalidaOperaciones::where('caja_id', '=', $caja->id)->get();


        $cajaBd      = Caja::find($caja->id);
        $caTotal     = CajaEntrada::where('caja_id', '=', $caja->id)->sum('monto');
        $csTotal     = CajaSalida::where('caja_id', '=', $caja->id)->sum('monto');
        $coTotal     = CajaOperaciones::where('caja_id', '=', $caja->id)->sum('monto');
        $cosTotal     = CajaSalidaOperaciones::where('caja_id', '=', $caja->id)->sum('monto');

        $cajaBd->calculteEntradasSaldias();

        return view(
            'caja.edit',
            [
                'cajaEntrada'   => $cajaEntrada,
                'cajaSalida'    => $cajaSalida,
                'cajaOperacion' => $cajaOperacion,
                'cajaOperacionSalida' => $cajaOperacionSalida,
                'caja'          => $caja,
                'caTotal'       => $caTotal,
                'csTotal'       => $csTotal,
                'coTotal'       => $coTotal,
                'cosTotal'       => $cosTotal
            ]
        );
    }


    public function update(UpdateCajaRequest $request, Caja $caja)
    {
        //
    }

    public function destroy(Caja $caja)
    {
        //
    }
    public function reportPdfCaja(Caja $caja, string $id)
    {
        $cajaEntrada = CajaEntrada::where('caja_id', '=', $id)->get();
        $cajaSalida  = CajaSalida::where('caja_id', '=', $id)->get();
        $cajaOperacion  = CajaOperaciones::where('caja_id', '=', $id)->get();
        $cajaOperacionSalida  = CajaSalidaOperaciones::where('caja_id', '=', $id)->get();


        $caja      = Caja::find($id);
        $caTotal     = CajaEntrada::where('caja_id', '=', $id)->sum('monto');
        $csTotal     = CajaSalida::where('caja_id', '=', $id)->sum('monto');
        $coTotal     = CajaOperaciones::where('caja_id', '=', $id)->sum('monto');
        $cosTotal     = CajaSalidaOperaciones::where('caja_id', '=', $id)->sum('monto');



        $pdf = Pdf::loadView('pdf.caja', [
            'cajaEntrada'   => $cajaEntrada,
            'cajaSalida'    => $cajaSalida,
            'cajaOperacion' => $cajaOperacion,
            'cajaOperacionSalida' => $cajaOperacionSalida,
            'caja'          => $caja,
            'caTotal'       => $caTotal,
            'csTotal'       => $csTotal,
            'coTotal'       => $coTotal,
            'cosTotal'       => $cosTotal
        ]);
        $customPaper = array(0, 0, 595.28, 841.89);
        $pdf->setPaper($customPaper);
        // Renderizar el contenido

        return $pdf->stream($id . '-' . $caja->user->name  . '.pdf');
    }
}
