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
        $pendingTransactions =  Transaction::where('transaction_status', 'pending')
                ->with(['currency', 'category'])
                ->orderBy('transaction_date_completed', 'asc')
                ->get();

        $otherData = 'placeholder for later modules';

        return view('dashboard', compact('pendingTransactions', 'otherData'));
    }
}