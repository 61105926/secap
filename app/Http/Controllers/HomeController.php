<?php

namespace App\Http\Controllers;

use App\Models\Bills;
use App\Models\Client;
use App\Models\Pay;
use App\Models\User;
use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sale =  Venta::count();
        $pays = Pay::count();
        $client = Client::count();
        $user = User::count();

        $totalEfectivo = Pay::where('type_transfer', '=', 'cash')->sum('amount');
        // dd($totalEfectivo);
        $totalDeposito = Pay::where('type_transfer', '=', 'deposit')->sum('amount');
        $totalTransferencia = Pay::where('type_transfer', '=', 'transfer')->sum('amount');
        $totalSalida = Bills::all()->sum('total_amount');
        $currentYear = date('Y');
        $previousYear = $currentYear - 1;
        
        // Consulta para el año actual
        $paysMonth = DB::select("
            SELECT MONTH(created_at) AS month, SUM(amount) AS total
            FROM pays
            WHERE YEAR(created_at) = $currentYear
            GROUP BY MONTH(created_at)
        ");
        
        $paysMonth_Sub = DB::select("
            SELECT MONTH(created_at) AS month, SUM(total_amount) AS total
            FROM bills
            WHERE YEAR(created_at) = $currentYear
            GROUP BY MONTH(created_at)
        ");
        
        // Consulta para el año anterior
        $paysMonth1 = DB::select("
            SELECT MONTH(created_at) AS month, SUM(amount) AS total
            FROM pays
            WHERE YEAR(created_at) = $previousYear
            GROUP BY MONTH(created_at)
        ");
        
        $paysMonth_Sub1 = DB::select("
            SELECT MONTH(created_at) AS month, SUM(total_amount) AS total
            FROM bills
            WHERE YEAR(created_at) = $previousYear
            GROUP BY MONTH(created_at)
        ");
        
        // Estructurar los datos
        $data = [];
        foreach ($paysMonth as $pay) {
            $data[] = [
                'month' => $pay->month,
                'total' => $pay->total,
            ];
        }
        
        $datasub = [];
        foreach ($paysMonth_Sub as $pay) {
            $datasub[] = [
                'month1' => $pay->month,
                'total1' => $pay->total,
            ];
        }
        
        $data1 = [];
        foreach ($paysMonth1 as $pay) {
            $data1[] = [
                'month2' => $pay->month,
                'total2' => $pay->total,
            ];
        }
        
        $datasub1 = [];
        foreach ($paysMonth_Sub1 as $pay) {
            $datasub1[] = [
                'month3' => $pay->month,
                'total3' => $pay->total,
            ];
        }
        
        return view('home', [
            'sale' => $sale,
            'pays' => $pays,
            'client' => $client,
            'user' => $user,
            'data' => json_encode($data),
            'datasub' => json_encode($datasub),
            'data1' => json_encode($data1),
            'datasub1' => json_encode($datasub1),
            'totalEfectivo' => $totalEfectivo,
            'totalDeposito' => $totalDeposito,
            'totalTransferencia' => $totalTransferencia,
            'totalSalida' => $totalSalida,
        ]);}
}
