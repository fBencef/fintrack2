<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    /**
     * Display a paginated list of all transactions
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function all(Request $request)
    {
        // 1. Fetch data from the Model
        $transactions = Transaction::with(['category', 'account'])
            ->orderBy('transaction_date_completed', 'desc') // Newest first
            ->paginate(50); // Automatically create pagination logic

        // 2. Return the View and pass the data
        return view('transactions.all', compact('transactions'));
    }
}