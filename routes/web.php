<?php

use App\Http\Controllers\AuditLogController;
use App\Http\Controllers\BranchController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\StockController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\UserManagementController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    Route::get('/audit-logs', [AuditLogController::class, 'index'])
        ->middleware('role:owner')
        ->name('audit-logs.index');

    Route::middleware(['role:owner'])->group(function () {
        Route::resource('branches', BranchController::class);
    });

    Route::middleware(['role:owner|manager|warehouse'])->group(function () {
        Route::resource('products', ProductController::class);
    });

    Route::middleware(['role:owner|manager|supervisor|warehouse'])->group(function () {
        Route::get('/stocks', [StockController::class, 'index'])
            ->name('stocks.index');
    });

    Route::middleware(['role:owner|manager|warehouse'])->group(function () {
        Route::post('/stocks/movement', [StockController::class, 'storeMovement'])
            ->name('stocks.movement.store');
    });

    Route::middleware(['role:owner|supervisor|cashier'])->group(function () {
        Route::resource('transactions', TransactionController::class)
            ->only(['index', 'create', 'store', 'show']);

        Route::get('/transactions/{transaction}/invoice', [TransactionController::class, 'invoice'])
            ->name('transactions.invoice');
    });

    Route::middleware(['role:owner|manager|supervisor'])->group(function () {
        Route::get('/reports/transactions', [ReportController::class, 'transactions'])
            ->name('reports.transactions');

        Route::get('/reports/transactions/pdf', [ReportController::class, 'transactionsPdf'])
            ->name('reports.transactions.pdf');
    });

    Route::middleware(['role:owner|manager|supervisor|warehouse'])->group(function () {
        Route::get('/reports/stocks', [ReportController::class, 'stocks'])
            ->name('reports.stocks');

        Route::get('/reports/stocks/pdf', [ReportController::class, 'stocksPdf'])
            ->name('reports.stocks.pdf');
    });

    Route::middleware(['role:owner|manager'])->group(function () {
        Route::resource('users', UserManagementController::class)
            ->except(['show']);
    });

    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');
});

require __DIR__.'/auth.php';
