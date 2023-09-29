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
use Darryldecode\Cart\Facades\CartFacade as Cart;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use SimpleSoftwareIO\QrCode\Facades\QrCode;



class CartController extends Controller
{
    public function shop()
    {
        $product = Product::all();
        // dd($products);
        return view('shop.shop', ['product' => $product,]);
    }

    public function cart()
    {
        $cartCollection = Cart::getContent();
        $product = Product::all();
        $client = Client::orderBy('id', 'desc')->get();
        $atm = Caja::where('state', '=', 0)->where('user_id', '=', Auth::user()->id)->get();

        // dd($client);
        return view('shop.cart', ['cartCollection' => $cartCollection, 'product' => $product, 'client' => $client, 'atm' => $atm,]);
    }
    public function remove(Request $request)
    {
        Cart::remove($request->id);
        return redirect()->route('cart.index')->with('success_msg', 'Item is removed!');
    }

    public function add(Request $request)
    {
        // dd($request->all());
        Cart::add(array(
            'id' => $request->id,
            'name' => $request->name,
            'price' => $request->total_price,
            'quantity' => $request->quantity,
            'attributes' => array(
                'imagen' => $request->img,
                'slug' => $request->slug,
            )

        ));
        return redirect()->route('cart.index')->with('success_msg', 'Item Agregado a sú Carrito!');
    }

    public function update(Request $request)
    {
        Cart::update(
            $request->id,
            array(
                'quantity' => array(
                    'relative' => false,
                    'value' => $request->quantity
                ),
            )
        );
        return redirect()->route('cart.index')->with('success_msg', 'Cart is Updated!');
    }

    public function clear()
    {
        Cart::clear();
        return redirect()->route('cart.index')->with('success_msg', 'Car is cleared!');
    }
    public function save(Request $request)
    {

        // dd($request->all());

        $venta = new Venta();
        $venta->id_user = $request->input('id_user');
        $venta->id_client = $request->input('id_client');
        $venta->subtotal = $request->input('subtotal');
        $venta->total_price = $request->input('total_price');
        $venta->discount = $request->input('discount');
        $venta->balance = $request->input('balance');
        $venta->description = $request->input('description');
        $venta->created_at = $request->input('created_at');
        $venta->id_product = $request->input('id_product');
        $venta->save();



        $pay = new Pay();
        $pay->id_user = Auth::user()->id;
        $pay->id_venta = $venta->id;
        $pay->type_transfer = $request->input('payment_type');
        if ($request->hasFile('deposit')) {
            $pay->desposit = $request->file('deposit')->getClientOriginalName();
            $request->file('deposit')->storeAs('public/comprobante', $pay->desposit);
        }
        $pay->transfer = $request->input('comprobante');
        $pay->amount = $request->input('pay');
        // $pay->created_at = date('Y-m-d H:i:s');
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


        Cart::clear();
        $sale = Venta::all();
        return redirect()->route('detalle-venta.index');
    }
}
