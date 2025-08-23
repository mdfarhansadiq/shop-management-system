<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Category;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Today's sales
        $todaySales = $user->sales()
            ->whereDate('created_at', Carbon::today())
            ->sum('final_amount');

        // This month's sales
        $monthSales = $user->sales()
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->sum('final_amount');

        // Total sales
        $totalSales = $user->sales()->sum('final_amount');

        // Recent sales
        $recentSales = $user->sales()
            ->with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Low stock products
        $lowStockProducts = $user->products()
            ->where('stock_quantity', '<', 10)
            ->take(5)
            ->get();

        // Low stock count
        $lowStockCount = $user->products()
            ->where('stock_quantity', '<', 10)
            ->count();

        // Counts
        $totalCustomers = $user->customers()->count();
        $totalProducts = $user->products()->count();
        $totalCategories = $user->categories()->count();

        return view('dashboard.index', compact(
            'todaySales', 'monthSales', 'totalSales', 'recentSales',
            'lowStockProducts', 'lowStockCount', 'totalCustomers', 'totalProducts', 'totalCategories'
        ));
    }
}
