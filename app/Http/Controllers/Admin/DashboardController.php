<?php

namespace App\Http\Controllers\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $year = $request->input('year', now()->year); // default: tahun sekarang

        // Statistik Pesanan
        $totalOrders = Order::whereYear('created_at', $year)->count();
        $fulfilledOrders = Order::whereYear('created_at', $year)
                                ->where('status', 'delivered')
                                ->count();
        $cancelledOrders = Order::whereYear('created_at', $year)
                                ->where('status', 'cancelled')
                                ->count();

        // Penjualan per bulan
        $monthlySales = Order::select(
                                DB::raw('MONTH(created_at) as month'),
                                DB::raw('SUM(total_price) as total')
                            )
                            ->whereYear('created_at', $year)
                            ->where('status', 'delivered')
                            ->groupBy('month')
                            ->orderBy('month')
                            ->get();

        // Produk terlaris
        $topProducts = OrderItem::select(
                                'product_id',
                                DB::raw('SUM(quantity) as total_qty')
                            )
                            ->groupBy('product_id')
                            ->orderByDesc('total_qty')
                            ->take(5)
                            ->with('product')
                            ->get()
                            ->map(function ($item) {
                                return (object)[
                                    'name' => $item->product->name ?? 'Produk Dihapus',
                                    'total_qty' => $item->total_qty
                                ];
                            });

        // Penjualan tahunan
        $yearlySales = Order::select(
                                DB::raw('YEAR(created_at) as year'),
                                DB::raw('SUM(total_price) as total')
                            )
                            ->where('status', 'delivered')
                            ->groupBy('year')
                            ->orderBy('year')
                            ->get();

        // Daftar tahun unik
        $availableYears = Order::select(DB::raw('YEAR(created_at) as year'))
                            ->distinct()
                            ->orderByDesc('year')
                            ->pluck('year');

        return view('admin.dashboard', compact(
            'year',
            'totalOrders',
            'fulfilledOrders',
            'cancelledOrders',
            'monthlySales',
            'topProducts',
            'yearlySales',
            'availableYears'
        ));
    }
}
