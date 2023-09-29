<?php

namespace App\Http\Controllers;

use App\Models\Caja;
use App\Models\CajaEntrada;
use App\Models\CajaOperaciones;
use App\Models\Client;
use App\Models\Pay;
use App\Models\Product;
use App\Models\Venta;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class SalesDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $sales = Venta::all();
        $productsBySale = [];

        foreach ($sales as $sale) {
            $product_ids = json_decode($sale->id_product, true); // Decodificar el JSON a un array asociativo
            $product_names = [];

            foreach ($product_ids as $product_id => $product) {
                $product_names[] = $product['name']; // Obtener el nombre del producto y agregarlo al array
            }

            $productsBySale[$sale->id] = $product_names;
        }

        return view('saledetail.index', compact('sales', 'productsBySale'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //dd($request->all());
        $venta = Venta::find($request->input('id_venta'));
        $venta->balance = $request->input('balance');

        $venta->save();
        $pay = new Pay();
        $pay->id_user = Auth::user()->id;
        $pay->id_venta = $request->input('id_venta');
        $pay->type_transfer = $request->input('payment_type');
        if ($request->hasFile('deposit')) {
            $pay->desposit = $request->file('deposit')->getClientOriginalName();
            $request->file('deposit')->storeAs('public/comprobante', $pay->desposit);
        }
        $pay->transfer = $request->input('comprobante');
        $pay->amount = $request->input('pay');
        if ($request->input('payment_type') == 'cash') {
            $pay->created_at =  $request->input('created_at');
            $pay->updated_at = $request->input('created_at');
        } else {
            $pay->created_at =  $request->input('created_at');
            $pay->updated_at = $request->input('fecha');
        }
        $pay->save();
        // caja
        if ($request->input('payment_type') == 'cash') {
            $caja  = new CajaEntrada($request->all());
            $caja->caja_id = $request->input('caja_id');
            $caja->type = 'Efectivo';
            $caja->monto = $request->input('pay');
            $caja->description = 'Nº Venta: ' . $venta->id;
            $caja->created_at = $request->input('created_at');
            $caja->save();
            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();
        } elseif ($request->input('payment_type') == 'transfer') {
            $caja  = new CajaOperaciones();
            $caja->caja_id = $request->input('caja_id');
            $caja->type = 'Transferencia';
            $caja->monto = $request->input('pay');
            $caja->description = 'Nº Venta: ' . $venta->id;
            $caja->created_at = $request->input('created_at');
            $caja->save();

            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();
        } else {
            $caja  = new CajaOperaciones();
            $caja->caja_id = $request->input('caja_id');
            $caja->type = 'Deposito';
            $caja->monto = $request->input('pay');
            $caja->description = 'Nº Venta: ' . $venta->id;
            $caja->created_at = $request->input('created_at');
            $caja->save();

            $cajaModelo = Caja::find($caja->caja_id);
            $cajaModelo->calculteEntradasSaldias();
        }


        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $venta = Venta::findOrFail($id);
        $client = Client::findOrFail($venta->id_client);
        $product = Product::all();
        $atm = Caja::where('state', '=', 0)->where('user_id', '=', Auth::user()->id)->get();
        $product_id = json_decode($venta->id_product, true);
        $pays = DB::table('pays')
            ->select('*', DB::raw('(SELECT SUM(amount) FROM pays p2 WHERE p2.id_venta = pays.id_venta) as monto_total'))
            ->where('id_venta', $venta->id)
            ->get();
        $sumPay = Pay::where('id_venta', $venta->id)->sum('amount');
        $qr = QrCode::size(100)->generate('A basic example of QR code!');
        $subtotal = $venta->subtotal;
        $total_price = $venta->total_price;
        $discount = $venta->discount;


        return view('saledetail.pay-index', [
            'venta' => $venta,
            'product' => $product,
            'client' => $client,
            'product_id' => $product_id,
            'subtotal' => $subtotal,
            'total_price' => $total_price,
            'pays' => $pays,
            'discount' => $discount,
            'sumPay' => $sumPay,
            'qr' => $qr,
            'atm' => $atm,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function reportPdf(string $id)
    {
        $venta = Venta::findOrFail($id);
        $product = Product::all();
        $client = Client::findOrFail($venta->id_client);
        $product_id = json_decode($venta->id_product, true);
        $pays = DB::table('pays')
            ->select('id_venta', 'id_user', 'created_at', 'updated_at', 'type_transfer', 'amount', DB::raw('(SELECT SUM(amount) FROM pays p2 WHERE p2.id_venta = pays.id_venta) as monto_total'))
            ->where('id_venta', $venta->id)
            ->get();
        $date = DB::table('pays')
            ->where('id_venta', $venta->id)
            ->max('created_at');
        $sumPay = Pay::where('id_venta', $venta->id)->sum('amount');
        $qr = QrCode::size(100)->generate('https://www.facebook.com/editorialtintaplana');
        $subtotal = $venta->subtotal;
        $total_price = $venta->total_price;
        $discount = $venta->discount;
        $pdf = Pdf::loadView('pdf.venta', [
            'venta' => $venta,
            'product' => $product,
            'client' => $client,
            'product_id' => $product_id,
            'subtotal' => $subtotal,
            'total_price' => $total_price,
            'pays' => $pays,
            'discount' => $discount,
            'sumPay' => $sumPay,
            'qr' => $qr,
            'date' => $date
        ]);
        $customPaper = array(0, 0, 595.28, 841.89);
        $pdf->setPaper($customPaper);


        return $pdf->stream($venta->id . '-' . $client->name . '.pdf');
    }
}
