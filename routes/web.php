<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\RecurringTransactionController;
use App\Http\Controllers\SettingsController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SubcategoryController;
use App\Http\Controllers\AccountController;
use App\Http\Controllers\CurrencyController;
use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;

// Dashboard as landing page
Route::get('/', function () {
    return auth()->check() ? redirect()->route('dashboard') : redirect()->route('login');
});

// Protected Routes (login needed)
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Recurring transactions
    Route::resource('recurring', RecurringTransactionController::class);
    Route::get('/recurring/{id}', [RecurringTransactionController::class, 'show'])->name('recurring.show');
    Route::put('/recurring/{id}', [RecurringTransactionController::class, 'update'])->name('recurring.update');
    Route::delete('/recurring/{recurring}', [RecurringTransactionController::class, 'destroy'])->name('recurring.destroy');

    // Filtered transaction views
    Route::get('/transactions/all', [TransactionController::class, 'all'])->name('transactions.all');
    Route::get('/transactions/incomes', [TransactionController::class, 'incomes'])->name('transactions.incomes');
    Route::get('/transactions/expenses', [TransactionController::class, 'expenses'])->name('transactions.expenses');

    // Transaction Details & Creation
    Route::get('/transactions/create', [TransactionController::class, 'create'])->name('transactions.create');
    Route::get('/transactions/{transaction}', [TransactionController::class, 'show'])->name('transactions.show');

    // Standard Resource for Edit, Update, Delete
    Route::resource('transactions', TransactionController::class)->except(['index', 'show', 'create']);

    // Approval
    Route::patch('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');

    // Subcategories
    Route::get('/api/categories/{category}/subcategories', [TransactionController::class, 'getSubcategories']);

    // Breeze Profile Routes (User Settings)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // App Settings
    Route::get('/settings', [SettingsController::class, 'index'])->name('settings.index');
    
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('/settings/categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::put('/settings/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');

    Route::delete('/subcategories/{subcategory}', [SubcategoryController::class, 'destroy'])->name('subcategories.destroy');
    Route::post('/settings/subcategories', [SubcategoryController::class, 'store'])->name('subcategories.store');
    Route::put('/settings/subcategories/{subcategory}', [SubcategoryController::class, 'update'])->name('subcategories.update');

    Route::post('/settings/accounts', [AccountController::class, 'store'])->name('accounts.store');
    Route::put('/settings/accounts/{account}', [AccountController::class, 'update'])->name('accounts.update');
    Route::delete('/settings/accounts/{account}', [AccountController::class, 'destroy'])->name('accounts.destroy');

    Route::post('/settings/currencies', [CurrencyController::class, 'store'])->name('currencies.store');
    Route::put('/settings/currencies/{currency}', [CurrencyController::class, 'update'])->name('currencies.update');
    Route::delete('/settings/currencies/{currency}', [CurrencyController::class, 'destroy'])->name('currencies.destroy');

    Route::patch('/settings/preferences', [SettingsController::class, 'updatePreferences'])->name('settings.update_preferences');

    //Notifications
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::delete('/notifications/{noticifaction}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

});

require __DIR__.'/auth.php';