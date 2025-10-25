<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('dashboard');
});

Route::get('/transactions/incomes', function () {
    return view('transactions.incomes');
});

Route::get('/transactions/expenses', function () {
    return view('transactions.expenses');
});

Route::get('/transactions', function () {
    return view('transactions.all_transactions');
});
