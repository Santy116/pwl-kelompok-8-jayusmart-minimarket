<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreStockMovementRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request): View
    {
        $stocks = Stock::with(['branch', 'product.category'])
            ->when($request->branch_id, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->when($request->product_id, function ($query, $productId) {
                $query->where('product_id', $productId);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('stocks.index', [
            'stocks' => $stocks,
            'branches' => Branch::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function storeMovement(StoreStockMovementRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $stock = Stock::firstOrCreate(
            [
                'branch_id' => $validated['branch_id'],
                'product_id' => $validated['product_id'],
            ],
            [
                'quantity' => 0,
                'minimum_stock' => 0,
            ]
        );

        if ($validated['type'] === 'in') {
            $stock->increment('quantity', $validated['quantity']);
        }

        if ($validated['type'] === 'out') {
            if ($stock->quantity < $validated['quantity']) {
                return back()
                    ->withInput()
                    ->with('error', 'Stok tidak mencukupi untuk melakukan stok keluar.');
            }

            $stock->decrement('quantity', $validated['quantity']);
        }

        if ($validated['type'] === 'adjustment') {
            $stock->update([
                'quantity' => $validated['quantity'],
            ]);
        }

        StockMovement::create([
            'branch_id' => $validated['branch_id'],
            'product_id' => $validated['product_id'],
            'user_id' => $request->user()->id,
            'transaction_id' => null,
            'type' => $validated['type'],
            'quantity' => $validated['quantity'],
            'movement_date' => $validated['movement_date'],
            'description' => $validated['description'] ?? null,
        ]);

        return redirect()
            ->route('stocks.index')
            ->with('success', 'Pergerakan stok berhasil disimpan.');
    }
}
