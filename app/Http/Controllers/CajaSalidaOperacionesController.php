<?php

namespace App\Http\Controllers;

use App\Models\CajaSalidaOperaciones;
use App\Http\Requests\StoreCajaSalidaOperacionesRequest;
use App\Http\Requests\UpdateCajaSalidaOperacionesRequest;
use App\Models\Bills;
use App\Models\Caja;
use App\Models\CajaSalida;
use Illuminate\Support\Facades\Auth;

class CajaSalidaOperacionesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->hasRole('cajero')) {
            $bills = Bills::all()->where('id_user', '=', Auth::user()->id);
            $atm = Caja::where('state', '=', 0)->where('user_id', '=', Auth::user()->id)->get();
            return view('bills.index', ['bills' => $bills, 'atm' => $atm]);
        } elseif (Auth::user()->hasRole('superadmin')) {
            $bills = Bills::all();
            $atm = Caja::where('state', '=', 0)->where('user_id', '=', Auth::user()->id)->get();
            return view('bills.index', ['bills' => $bills, 'atm' => $atm]);
        } elseif (Auth::user()->hasRole('admin')) {

            $bills = Bills::all();
            $atm = Caja::where('state', '=', 0)->where('user_id', '=', Auth::user()->id)->get();
            return view('bills.index', ['bills' => $bills, 'atm' => $atm]);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCajaSalidaOperacionesRequest $request)
    {
        // dd($request->all());

        $bills = new Bills();
        $bills->id_user = Auth::user()->id;
        $bills->type_transfer = $request->input('payment_type');
        if ($request->hasFile('deposit')) {
            $bills->desposit = $request->file('deposit')->getClientOriginalName();
            $request->file('deposit')->storeAs('public/comprobante', $bills->desposit);
        }
        $bills->transfer = $request->input('comprobante');
        $bills->category = $request->input('category');
        $bills->name = $request->input('name');
        $bills->quantity = $request->input('quantity');
        $bills->amount = $request->input('price');
        $bills->description = $request->input('description');
        $bills->total_amount = $request->input('total_price');
        $bills->created_at =  $request->input('created_at');
        $bills->updated_at = $request->input('fecha');
        $bills->save();


        if ($request->input('payment_type') == 'cash') {
            $caja  = new CajaSalida($request->all());
            $caja->caja_id = $request->input('caja_id');
            $caja->type = 'Efectivo';
            $caja->monto = $request->input('total_price');
            $caja->description = $request->input('name');
            $caja->created_at =  $request->input('created_at');
            $caja->save();
            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();
        } elseif ($request->input('payment_type') == 'transfer') {
            $caja  = new CajaSalidaOperaciones();
            $caja->caja_id = $request->input('caja_id');
            $caja->type = 'Transferencia';
            $caja->monto = $request->input('total_price');
            $caja->description = $request->input('name');
            $caja->created_at =  $request->input('created_at');
            $caja->save();

            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();
        } else {
            $caja  = new CajaSalidaOperaciones();
            $caja->caja_id = $request->input('caja_id');
            $caja->type = 'Deposito';
            $caja->monto = $request->input('total_price');
            $caja->description =  $request->input('name');
            $caja->created_at =   $request->input('created_at');
            $caja->save();

            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();
        }
        $cajaModelo = Caja::find($caja->caja_id);
        $cajaModelo->calculteEntradasSaldias();

        return redirect('bills');
    }

    /**
     * Display the specified resource.
     */
    public function show(CajaSalidaOperaciones $cajaSalidaOperaciones)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CajaSalidaOperaciones $cajaSalidaOperaciones)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCajaSalidaOperacionesRequest $request, CajaSalidaOperaciones $cajaSalidaOperaciones)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(CajaSalidaOperaciones $cajaSalidaOperaciones)
    {
        //
    }
}
