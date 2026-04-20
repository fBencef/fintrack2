<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\DashboardController;

// Dashboard / Home page
Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

// Recurring transactions
Route::resource('/recurring', RecurringTransactionController::class);

// All transactions
Route::get('/transactions', [TransactionController::class, 'all'])->name('transactions.all');

// Incomes
Route::get('/transactions/incomes', [TransactionController::class, 'incomes'])->name('transactions.incomes');

// Expenses
Route::get('/transactions/expenses', [TransactionController::class, 'expenses'])->name('transactions.expenses');

Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');

// Transaction details
// This has to be at the end because of wild-cards (?)
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

// AJAX route for the "Details" modal
Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])
    ->name('transactions.show');

// Standard Resource routes for Edit, Update, and Delete
// Automatically creates /transactions/{id}/edit and DELETE (Laravel)
Route::resource('transactions', TransactionController::class)->except(['index', 'show']);

// Transaction approval
Route::patch('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])
    ->name('transactions.approve');


// Route for the dynamic subcat dropdowns
Route::get('/api/categories/{category}/subcategories', [TransactionController::class, 'getSubcategories']);