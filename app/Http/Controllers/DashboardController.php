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
    public function index(Request $request) {    
        $user = auth()->user();
        $now = now();

        // Get month from URL or default to current
        $selectedMonth = $request->query('month', now()->format('Y-m'));
        $date = \Carbon\Carbon::parse($selectedMonth);

        // Month select
        $prevMonth = $date->copy()->subMonth()->format('Y-m');
        $nextMonth = $date->copy()->addMonth()->format('Y-m');
        $isCurrentMonth = $date->isCurrentMonth() && $date->isCurrentYear();
    
        $defaultCurrency = Currency::where('user_id', $user->user_id)
            ->where('is_default_currency', true)
            ->first() ?? Currency::where('user_id', $user->user_id)->first();

        //Pending recurring transactions
        $pendingTransactions =  Transaction::where('transaction_status', 'pending')
            ->with(['currency', 'category'])
            ->orderBy('transaction_date_completed', 'asc')
            ->get();

        //MOnthly total spending
        $monthlyTotal = Transaction::where('user_id', $user->user_id)
            ->whereMonth('transaction_date_completed', $date->month)
            ->whereYear('transaction_date_completed', $date->year)
            ->where('transaction_amount', '<', 0)
            ->where('transaction_status','confirmed')
            ->sum('transaction_amount');

        $monthlyTotal = abs($monthlyTotal);

        $currentMonthLabel = $date->format('Y. m.');

        // Recent transactions
        $recentTransactions = Transaction::where('user_id', $user->user_id)
            ->with(['category', 'subcategory','currency'])
            ->orderBy('transaction_id', 'desc')
            ->where('transaction_status','confirmed')
            ->take(5)
            ->get();

        //Spending categories
        $spendingCategories = Transaction::where('transactions.user_id', $user->user_id)
            ->whereMonth('transaction_date_completed', $date->month)
            ->whereYear('transaction_date_completed', $date->year)
            ->where('transaction_amount', '<', 0)
            ->where('transaction_status','confirmed')
            ->join('categories', 'transactions.category_id', '=', 'categories.category_id')
            ->selectRaw('categories.category_name, SUM(ABS(transactions.transaction_amount)) as total')
            ->groupBy('categories.category_name')
            ->get();


        return view('dashboard', compact('pendingTransactions', 'monthlyTotal', 'defaultCurrency', 'currentMonthLabel', 'recentTransactions', 'spendingCategories', 'selectedMonth', 'nextMonth', 'prevMonth', 'isCurrentMonth'));
    }
}