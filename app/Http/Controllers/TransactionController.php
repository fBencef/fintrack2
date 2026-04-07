<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use App\Models\Transaction;
use Illuminate\Http\Request;
use SebastianBergmann\CodeCoverage\FileCouldNotBeWrittenException;
use function PHPUnit\Framework\isNull;

class TransactionController extends Controller
{
    /**
     * Display a paginated list of all transactions
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function all(Request $request)
    {
    /*    
    // 1. Fetch data from the Model
        $transactions = Transaction::with(['category', 'account','subcategory'])
            ->orderBy('transaction_date_completed', 'desc') // Newest first
            ->paginate(25); // Automatically create pagination logic

        // 2. Return the View and pass the data
        return view('transactions.all', compact('transactions'));
        */

        // Start query builder
        $query = Transaction::with(['category', 'subcategory', 'account', 'currency']);

        // Filter by Search (in description)
        if ($request->filled('search')) {
            $query->where('transaction_description', 'like', '%' . $request->search . '%');
        }

        // Filter by Category and Subactegory
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
            if($request->filled('subcategory_id')) {
                $query->where('subcategory_id', $request->subcategory_id);
            }
        }

        // Get data
        $transactions = $query->orderBy('transaction_date_completed', 'desc')->paginate(25);

        // Get content for the dropdown menus
        $categories = Category::all();

        if($request->filled('category_id')) {
            $subcategories = Subcategory::where('category_id', $request->category_id)->get();    
        }
        else $subcategories = Subcategory::all();

        //Return the results of query with variables needed in the view.
        return view('transactions.all', compact('transactions', 'categories','subcategories'));
    }

    public function expenses(Request $request) {
        // Get all existing years from transactions (for year selector)
        $existingYears = Transaction::selectRaw('YEAR(transaction_date_completed) as year')
            ->distinct()
            ->orderBy('year')
            ->pluck('year');

        // Get selected year from URL
        // Default is newest
        $selectedYear = $request->get('year', $existingYears->first() ?? date('Y'));
    
        // Fetch only expense transactions with their relationships
        $transactions = Transaction::whereHas('category', function ($q) {
            $q->whereNot('category_direction','+');
        })
        ->whereYear('transaction_date_completed', $selectedYear)
        ->where('transaction_amount','<',0)
        ->with(['category','subcategory'])
        ->get();

        $pivotData = [];
        //TODO: remove hard-coding from this part
        $months = ['Január', 'Február', 'Március', 'Április', 'Május', 'Június','Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'];

        foreach ($transactions as $transaction) {
            //Get month number (from record) and pair it to the string array values
            $monthNumber = (int)date('n', strtotime($transaction->transaction_date_completed)) - 1;
            $monthName = $months[$monthNumber];

            $categoryName = $transaction->category->category_name;
            $subcategoryName = $transaction->subcategory?->subcategory_name ?? null;

            // Initialize nested arrays if not set
            if (!isset($pivotData[$categoryName])) {
                $pivotData[$categoryName] = ['total' => array_fill_keys($months, 0), 'subs' => []];
            }
            if($subcategoryName) {
                if (!isset($pivotData[$categoryName]['subs'][$subcategoryName])) {
                    $pivotData[$categoryName]['subs'][$subcategoryName] = array_fill_keys($months, 0);
                }
            }

            // Add to the specific subcategory month
            if($subcategoryName) {
                $pivotData[$categoryName]['subs'][$subcategoryName][$monthName] += $transaction->transaction_amount * -1;
            }

            // Add to the main category total for that month
            $pivotData[$categoryName]['total'][$monthName] += $transaction->transaction_amount * -1;
        }

        //DEBUG TOOL - Stops the app and shows the data
        //dd($pivotData['Szolgáltatások']);

        //Getting the latest transactions
        $latestExpenses = $this->latest_transactions(5, true);
        
        return view('transactions.expenses', compact('pivotData','months','existingYears', 'selectedYear','latestExpenses'));
    }

    public function incomes(Request $request) {
        // Get all existing years from transactions (for year selector)
        $existingYears = Transaction::selectRaw('YEAR(transaction_date_completed) as year')
            ->distinct()
            ->orderBy('year')
            ->pluck('year');

        // Get selected year from URL
        // Default is newest
        $selectedYear = $request->get('year', $existingYears->first() ?? date('Y'));
    
        // Fetch only expense transactions with their relationships
        $transactions = Transaction::whereHas('category', function ($q) {
            $q->whereNot('category_direction','-');
        })
        ->whereYear('transaction_date_completed', $selectedYear)
        ->where('transaction_amount','>',0)
        ->with(['category','subcategory'])
        ->get();

        $pivotData = [];
        //TODO: remove hard-coding from this part
        $months = ['Január', 'Február', 'Március', 'Április', 'Május', 'Június','Július', 'Augusztus', 'Szeptember', 'Október', 'November', 'December'];

        foreach ($transactions as $transaction) {
            //Get month number (from record) and pair it to the string array values
            $monthNumber = (int)date('n', strtotime($transaction->transaction_date_completed)) - 1;
            $monthName = $months[$monthNumber];

            $categoryName = $transaction->category->category_name;
            $subcategoryName = $transaction->subcategory?->subcategory_name ?? null;

            // Initialize nested arrays if not set
            if (!isset($pivotData[$categoryName])) {
                $pivotData[$categoryName] = ['total' => array_fill_keys($months, 0), 'subs' => []];
            }
            if($subcategoryName) {
                if (!isset($pivotData[$categoryName]['subs'][$subcategoryName])) {
                    $pivotData[$categoryName]['subs'][$subcategoryName] = array_fill_keys($months, 0);
                }
            }

            // Add to the specific subcategory month
            if($subcategoryName) {
                $pivotData[$categoryName]['subs'][$subcategoryName][$monthName] += $transaction->transaction_amount;
            }

            // Add to the main category total for that month
            $pivotData[$categoryName]['total'][$monthName] += $transaction->transaction_amount;
        }

        //Getting the latest transactions
        $latestIncomes = $this->latest_transactions(5, false);
        
        return view('transactions.incomes', compact('pivotData','months','existingYears', 'selectedYear','latestIncomes'));
    }

    public function show(Transaction $transaction) {
        //Partial view - inside modal
        return view('transactions.partials.show', compact('transaction'));
    }

    private function latest_transactions(int $number_of_entries, bool $is_expense) {
        $query = Transaction::with(['category','subcategory','currency']);

        if($is_expense)
            $query->where('transaction_amount', '<', 0);
        else
            $query->where('transaction_amount', '>', 0);

        return $query
            ->orderBy('transaction_date_completed', 'desc')
            ->orderBy('transaction_id','desc')
            ->limit($number_of_entries)
            ->get();
    }
}