<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransactionRequest;
use App\Models\Branch;
use App\Models\Product;
use App\Models\Stock;
use App\Models\StockMovement;
use App\Models\Transaction;
use App\Models\TransactionItem;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index(Request $request): View
    {
        $transactions = Transaction::with(['branch', 'user'])
            ->when($request->branch_id, function ($query, $branchId) {
                $query->where('branch_id', $branchId);
            })
            ->when($request->start_date, function ($query, $startDate) {
                $query->whereDate('transaction_date', '>=', $startDate);
            })
            ->when($request->end_date, function ($query, $endDate) {
                $query->whereDate('transaction_date', '<=', $endDate);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('transactions.index', [
            'transactions' => $transactions,
            'branches' => Branch::orderBy('name')->get(),
        ]);
    }

    public function create(): View
    {
        return view('transactions.create', [
            'branches' => Branch::orderBy('name')->get(),
            'products' => Product::orderBy('name')->get(),
        ]);
    }

    public function store(StoreTransactionRequest $request): RedirectResponse
    {
        $validated = $request->validated();

        $transaction = DB::transaction(function () use ($request, $validated) {
            $totalAmount = 0;

            foreach ($validated['items'] as $item) {
                $totalAmount += $item['quantity'] * $item['price'];
            }

            $transaction = Transaction::create([
                'branch_id' => $validated['branch_id'],
                'user_id' => $request->user()->id,
                'invoice_number' => $this->generateInvoiceNumber(),
                'transaction_date' => $validated['transaction_date'],
                'total_amount' => $totalAmount,
                'paid_amount' => $validated['paid_amount'],
                'change_amount' => $validated['paid_amount'] - $totalAmount,
                'payment_method' => $validated['payment_method'],
                'status' => 'paid',
            ]);

            foreach ($validated['items'] as $item) {
                $stock = Stock::where('branch_id', $validated['branch_id'])
                    ->where('product_id', $item['product_id'])
                    ->first();

                if (! $stock || $stock->quantity < $item['quantity']) {
                    throw new \Exception('Stok produk tidak mencukupi.');
                }

                $subtotal = $item['quantity'] * $item['price'];

                TransactionItem::create([
                    'transaction_id' => $transaction->id,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $subtotal,
                ]);

                $stock->decrement('quantity', $item['quantity']);

                StockMovement::create([
                    'branch_id' => $validated['branch_id'],
                    'product_id' => $item['product_id'],
                    'user_id' => $request->user()->id,
                    'transaction_id' => $transaction->id,
                    'type' => 'out',
                    'quantity' => $item['quantity'],
                    'movement_date' => $validated['transaction_date'],
                    'description' => 'Stok keluar dari transaksi penjualan.',
                ]);
            }

            return $transaction;
        });

        return redirect()
            ->route('transactions.show', $transaction)
            ->with('success', 'Transaksi berhasil disimpan.');
    }

    public function show(Transaction $transaction): View
    {
        $transaction->load([
            'branch',
            'user',
            'transactionItems.product',
        ]);

        return view('transactions.show', [
            'transaction' => $transaction,
        ]);
    }

    public function invoice(Transaction $transaction): View
    {
        $transaction->load([
            'branch',
            'user',
            'transactionItems.product',
        ]);

        return view('transactions.invoice', [
            'transaction' => $transaction,
        ]);
    }

    private function generateInvoiceNumber(): string
    {
        $date = now()->format('Ymd');
        $lastTransaction = Transaction::whereDate('created_at', today())->latest()->first();
        $sequence = $lastTransaction ? $lastTransaction->id + 1 : 1;

        return 'INV-'.$date.'-'.str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
    }
}
