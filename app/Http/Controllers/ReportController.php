<?php

namespace App\Http\Controllers;

use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\Transaction;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function transactions(Request $request): View
    {
        $transactions = $this->transactionQuery($request)
            ->paginate(10)
            ->withQueryString();

        return view('reports.transactions', [
            'transactions' => $transactions,
            'branches' => $this->availableBranches($request),
            'filters' => $request->only([
                'branch_id',
                'start_date',
                'end_date',
                'status',
            ]),
        ]);
    }

    public function transactionsPdf(Request $request)
    {
        $transactions = $this->transactionQuery($request)->get();

        $pdf = Pdf::loadView('reports.transactions-pdf', [
            'transactions' => $transactions,
            'filters' => $request->only([
                'branch_id',
                'start_date',
                'end_date',
                'status',
            ]),
        ]);

        return $pdf->download('laporan-transaksi.pdf');
    }

    public function stocks(Request $request): View
    {
        $stocks = $this->stockQuery($request)
            ->paginate(10)
            ->withQueryString();

        return view('reports.stocks', [
            'stocks' => $stocks,
            'branches' => $this->availableBranches($request),
            'products' => Product::orderBy('name')->get(),
            'filters' => $request->only([
                'branch_id',
                'product_id',
            ]),
        ]);
    }

    public function stocksPdf(Request $request)
    {
        $stocks = $this->stockQuery($request)->get();

        $pdf = Pdf::loadView('reports.stocks-pdf', [
            'stocks' => $stocks,
            'filters' => $request->only([
                'branch_id',
                'product_id',
            ]),
        ]);

        return $pdf->download('laporan-stok.pdf');
    }

    private function transactionQuery(Request $request)
    {
        $user = $request->user();

        return Transaction::with(['branch', 'user'])
            ->when(! $user->hasRole('owner'), function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })
            ->when($user->hasRole('owner') && $request->branch_id, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->when($request->start_date, function ($query, $startDate) {
                $query->whereDate('transaction_date', '>=', $startDate);
            })
            ->when($request->end_date, function ($query, $endDate) {
                $query->whereDate('transaction_date', '<=', $endDate);
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest();
    }

    private function stockQuery(Request $request)
    {
        $user = $request->user();

        return Stock::with(['branch', 'product.category'])
            ->when(! $user->hasRole('owner'), function ($query) use ($user) {
                $query->where('branch_id', $user->branch_id);
            })
            ->when($user->hasRole('owner') && $request->branch_id, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->when($request->product_id, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->latest();
    }

    private function availableBranches(Request $request)
    {
        $user = $request->user();

        if ($user->hasRole('owner')) {
            return Branch::orderBy('name')->get();
        }

        return Branch::where('id', $user->branch_id)->get();
    }
}
