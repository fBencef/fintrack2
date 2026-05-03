<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Subcategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\FileCouldNotBeWrittenException;
use function PHPUnit\Framework\isNull;

class DashboardController extends Controller
{
    public function index() {    
        $user = auth()->user();
        $now = now();
    
        //Pending recurring transactions
        $pendingTransactions =  Transaction::where('transaction_status', 'pending')
            ->with(['currency', 'category'])
            ->orderBy('transaction_date_completed', 'asc')
            ->get();

        $defaultCurrency = Currency::where('user_id', $user->user_id)
            ->where('is_default_currency', true)
            ->first() ?? Currency::where('user_id', $user->user_id)->first();

        //MOnthly total spending
        $monthlyTotal = Transaction::where('user_id', $user->user_id)
            ->whereMonth('transaction_date_completed', $now->month)
            ->whereYear('transaction_date_completed', $now->year)
            ->where('transaction_amount', '<', 0)
            ->sum('transaction_amount');

        $monthlyTotal = abs($monthlyTotal);

        $currentMonthLabel = $now->format('Y. m.');

        // Recent transactions
        $recentTransactions = Transaction::where('user_id', $user->user_id)
            ->with(['category', 'subcategory','currency'])
            ->orderBy('transaction_date_completed', 'desc')
            ->take(5)
            ->get();

        //Spending categories


        return view('dashboard', compact('pendingTransactions', 'monthlyTotal', 'defaultCurrency', 'currentMonthLabel', 'recentTransactions'));
    }
}