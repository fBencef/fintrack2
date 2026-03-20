<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;

// Dashboard / Home page
Route::get('/', [TransactionController::class, 'index'])->name('dashboard');

// All transactions
Route::get('/transactions', [TransactionController::class, 'all'])->name('transactions.all');

// Incomes
Route::get('/transactions/incomes', [TransactionController::class, 'incomes'])->name('transactions.incomes');

// Expenses
Route::get('/transactions/expenses', [TransactionController::class, 'expenses'])->name('transactions.expenses');

// Transaction details
// This has to be at the end because of wild-cards (?)
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');