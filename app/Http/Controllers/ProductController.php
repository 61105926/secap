<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;
use App\Models\Categoria;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $product = Product::all();
        $category = Categoria::all();

        return view('products.index', ['product' => $product, 'category' => $category]);
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
    public function store(StoreProductRequest $request)
    {
        // dd($request->all());
        $product = new Product();
        $product->id_category = $request->input('id_category');
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->discount = $request->input('discount');
        $product->total_price = $request->input('price') - $request->input('discount');
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/products', $product->image);
        } else {
            $product->image = "AdminLTELogo.jpg";
        };
        $product->save();
        return redirect('productos');
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product, string $id)
    {
        // dd($request->all());
        $product =  Product::find($id);
        $product->id_category = $request->input('id_category');
        $product->name = $request->input('name');
        $product->price = $request->input('price');
        $product->stock = $request->input('stock');
        $product->discount = $request->input('discount');
        $product->total_price = $request->input('price') - $request->input('discount');
        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->getClientOriginalName();
            $request->file('image')->storeAs('public/products', $product->image);
        }
        $product->save();
        return redirect('productos');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product, string $id)
    {
        $product = Product::find($id);
        $product->delete();
        return redirect('productos')->with('eliminar', 'ok');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');

        $products = Product::where('name', 'like', "%$query%")
            ->get();

        return response()->json($products);
    }
}
