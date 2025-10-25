<?php

use Illuminate\Support\Facades\Route;

//Dashboard / Home page
Route::get('/', function () {
    return view('dashboard');
});

// Incomes (table)
Route::get('/transactions/incomes', function () {
    return view('transactions.incomes');
});

// Expenses (table)
Route::get('/transactions/expenses', function () {
    return view('transactions.expenses');
});

// All transactions
Route::get('/transactions', function () {
    return view('transactions.all_transactions');
});

// Transaction details
// Always needs to be at the bottom  because of how Laravel handles wildcards
Route::get('/transactions/{id}', function ($id) {
    return view('transactions.show', ["id" => $id]);
});
