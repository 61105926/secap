<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use App\Http\Requests\StoreVentaRequest;
use App\Http\Requests\UpdateVentaRequest;
use App\Models\Pay;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class VentaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Venta::where('balance', '=', 0)->get();
        $productsBySale = [];


        foreach ($sales as $sale) {
            $product_ids = json_decode($sale->id_product, true); // Decodificar el JSON a un array asociativo
            $product_names = [];

            foreach ($product_ids as $product_id => $product) {
                $product_names[] = $product['name']; // Obtener el nombre del producto y agregarlo al array
            }

            $productsBySale[$sale->id] = $product_names;
        }


        return view('saledetail.completed-sale', compact('sales', 'productsBySale'));
    }
    public function cobrosTotal(Venta $venta)
    {


        if (Auth::user()->hasRole('cajero')) {
            $twoMonthsAgo = Carbon::now()->subMonths(2);
            $currentUserId = Auth::user()->id;

            $pays = Pay::where('id_user', $currentUserId)
                ->whereBetween('created_at', [$twoMonthsAgo, Carbon::now()])
                ->get();

            return view('cobros.index', ['pays' => $pays]);
        } elseif (Auth::user()->hasRole('superadmin')) {
            $pays = Pay::all();
            return view('cobros.index', ['pays' => $pays]);
        } elseif (Auth::user()->hasRole('admin')) {

            $pays = Pay::all();
            return view('cobros.index', ['pays' => $pays]);
        }
    }

    public function ventaPendiente(Venta $venta)
    {
        $sales = Venta::where('balance', '!=', 0)->get();
        $productsBySale = [];

        foreach ($sales as $sale) {
            $product_ids = json_decode($sale->id_product, true); // Decodificar el JSON a un array asociativo
            $product_names = [];

            foreach ($product_ids as $product_id => $product) {
                $product_names[] = $product['name']; // Obtener el nombre del producto y agregarlo al array
            }

            $productsBySale[$sale->id] = $product_names;
        }
        return view('saledetail.earring', compact('sales', 'productsBySale'));
    }

    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreVentaRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Venta $venta)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Venta $venta)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateVentaRequest $request, Venta $venta, string $id)
    {
        $venta = Venta::findOrFail($id);
        if ($request->extra) {
            $venta->extra = $request->extra;
            $venta->total_price += $request->extra;
            $venta->balance += $request->extra;
        }
        // Si el campo total_price tiene un valor, actualizarlo
        if ($request->total_price) {
            $venta->total_price = $request->total_price;
        }
        if ($request->input('description') != null) {

            $venta->description = $request->input('description');
        }
        $venta->save();

        return back();
    }


    public function destroy(Venta $venta)
    {
    } //

}
