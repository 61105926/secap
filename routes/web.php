<?php

use App\Http\Controllers\CajaController;
use App\Http\Controllers\CajaEntradaController;
use App\Http\Controllers\CajaSalidaController;
use App\Http\Controllers\CajaSalidaOperacionesController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\ClientController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SalesDetailController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\VentaController;
use App\Livewire\Student\StudentController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Spatie\Permission\Models\Role;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('auth.login');
});

Auth::routes();
Route::middleware(['auth'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('role:admin|superadmin');

    Route::resource('/usuarios', UserController::class)->name('', 'usuarios')->middleware('role:admin|superadmin');
    Route::resource('/clientes', ClientController::class)->name('', 'clientes')->middleware('auth');
    Route::get('/estudiantes', StudentController::class)->name('estudiantes');

    Route::post('/import', [ClientController::class, 'import'])->name('import')->middleware('auth');
    Route::resource('/categorias', CategoriaController::class)->name('', 'categorias')->middleware('role:admin|superadmin');
    Route::resource('/productos', ProductController::class)->name('', 'productos')->middleware('role:admin|superadmin');
    Route::post('modalClient', [ClientController::class, 'modalclient'])->name('modalClient');
    Route::get('/save', [CartController::class, 'save'])->name('cart.save')->middleware('role:admin|superadmin|cajero');
    Route::get('/products/search', [ProductController::class, 'search'])->name('products.search');

    Route::get('/ventas', [CartController::class, 'shop'])->name('shop')->middleware('role:admin|superadmin|cajero');
    Route::get('/cart', [CartController::class, 'cart'])->name('cart.index')->middleware('role:admin|superadmin|cajero');
    Route::post('/add', [CartController::class, 'add'])->name('cart.store')->middleware('role:admin|superadmin|cajero');
    Route::post('/update', [CartController::class, 'update'])->name('cart.update')->middleware('role:admin|superadmin|cajero');
    Route::post('/remove', [CartController::class, 'remove'])->name('cart.remove')->middleware('role:admin|superadmin|cajero');
    Route::post('/clear', [CartController::class, 'clear'])->name('cart.clear')->middleware('role:admin|superadmin|cajero');
    Route::post('/save', [CartController::class, 'save'])->name('cart.save')->middleware('role:admin|superadmin|cajero');

    Route::resource('/detalle-venta', SalesDetailController::class)->name('', 'detalle-venta')->middleware('role:admin|superadmin|cajero');
    Route::get('detalles/{detalles}', [SalesDetailController::class, 'reportPdf'])->name('reportPdf'); //pdf reports 
    Route::get('reportPdfCaja/{detalles}', [CajaController::class, 'reportPdfCaja'])->name('reportPdfCaja'); //pdf reports 

    Route::resource('/venta-completa', VentaController::class)->name('', 'venta-completa')->middleware('role:admin|superadmin|cajero');
    Route::get('/cobros', [VentaController::class, 'cobrosTotal'])->name('', 'cobros')->middleware('role:admin|superadmin|cajero');
    Route::resource('bills', CajaSalidaOperacionesController::class)->name('', 'bills')->middleware('role:admin|superadmin|cajero');
    Route::get('/venta-pendiente', [VentaController::class, 'ventaPendiente'])->name('', 'venta-pendiente')->middleware('role:admin|superadmin|cajero');

    Route::resource('caja', CajaController::class)->name('', 'caja')->middleware('role:admin|superadmin|cajero');
    Route::resource('cajaEntrada', CajaEntradaController::class)->name('', 'cajaEntrada')->middleware('role:admin|superadmin|cajero');
    Route::resource('cajaSalida', CajaSalidaController::class)->name('', 'cajaSalida')->middleware('role:admin|superadmin|cajero');
});
