<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request): View
    {
        $user = $request->user();

        if ($user->hasRole('owner')) {
            return $this->ownerDashboard();
        }

        return $this->branchDashboard($user);
    }

    private function ownerDashboard(): View
    {
        return view('dashboard.index', [
            'totalBranches' => Branch::count(),
            'todayTransactions' => Transaction::whereDate('transaction_date', today())->count(),
            'totalRevenue' => Transaction::where('status', 'paid')->sum('total_amount'),
            'totalProducts' => Product::count(),
            'lowStocks' => Stock::whereColumn('quantity', '<=', 'minimum_stock')->count(),
            'branches' => Branch::withCount(['transactions', 'stocks'])->get(),
            'recentTransactions' => Transaction::with(['branch', 'user'])
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }

    private function branchDashboard($user): View
    {
        $branchId = $user->branch_id;

        return view('dashboard.index', [
            'totalBranches' => null,
            'todayTransactions' => Transaction::where('branch_id', $branchId)
                ->whereDate('transaction_date', today())
                ->count(),
            'totalRevenue' => Transaction::where('branch_id', $branchId)
                ->where('status', 'paid')
                ->sum('total_amount'),
            'totalProducts' => Stock::where('branch_id', $branchId)->count(),
            'lowStocks' => Stock::where('branch_id', $branchId)
                ->whereColumn('quantity', '<=', 'minimum_stock')
                ->count(),
            'branches' => Branch::where('id', $branchId)->get(),
            'recentTransactions' => Transaction::with(['branch', 'user'])
                ->where('branch_id', $branchId)
                ->latest()
                ->limit(5)
                ->get(),
        ]);
    }
}
