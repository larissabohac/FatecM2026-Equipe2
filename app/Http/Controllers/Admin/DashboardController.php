<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | PERÍODO DE FILTRO
        |--------------------------------------------------------------------------
        | Se não informar datas, mostra o mês atual
        */

        $start = $request->start_date
            ? Carbon::parse($request->start_date)->startOfDay()
            : Carbon::now()->startOfMonth();

        $end = $request->end_date
            ? Carbon::parse($request->end_date)->endOfDay()
            : Carbon::now()->endOfMonth();


        /*
        |--------------------------------------------------------------------------
        | INDICADORES GERAIS
        |--------------------------------------------------------------------------
        */

        $totalProducts = Product::count();
        $featured = Product::where('featured', true)->count();
        $totalUsers = User::count();


        /*
        |--------------------------------------------------------------------------
        | CONSULTA BASE DE VENDAS FILTRADAS
        |--------------------------------------------------------------------------
        */

        $salesQuery = Sale::whereBetween('created_at', [$start, $end]);


        $totalSalesAdmin = Sale::sum('total');
        $totalSalesOnline = Order::where('status','paid')->sum('total');

        $totalRevenue = $totalSalesAdmin + $totalSalesOnline;

        $totalOrders = Sale::count() +
                    Order::where('status','paid')->count();
        /*
        |--------------------------------------------------------------------------
        | VENDAS POR FORMA DE PAGAMENTO
        |--------------------------------------------------------------------------
        */

        $salesByPayment = Sale::select(
                'payment_method',
                DB::raw('COUNT(*) as total_sales'),
                DB::raw('SUM(total) as total_amount')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('payment_method')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | VENDAS MENSAIS (PARA GRÁFICO)
        |--------------------------------------------------------------------------
        */

        $monthlySales = Sale::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(total) as total')
            )
            ->whereBetween('created_at', [$start, $end])
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->orderBy('month')
            ->get();


        /*
        |--------------------------------------------------------------------------
        | FLUXO DE CAIXA (OPCIONAL)
        |--------------------------------------------------------------------------
        */

        $cashIn = Sale::whereBetween('created_at', [$start, $end])->sum('total');
        $cashOut = 0; // caso futuramente tenha tabela de despesas
        $balance = $cashIn - $cashOut;


        /*
        |--------------------------------------------------------------------------
        | RETORNO PARA A VIEW
        |--------------------------------------------------------------------------
        */

        return view('admin.dashboard', compact(
            'totalProducts',
            'featured',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'salesByPayment',
            'monthlySales',
            'cashIn',
            'cashOut',
            'balance',
            'start',
            'end'
        ));
    }
}