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

class TransactionController extends Controller
{
    /**
     * Display a paginated list of all transactions
     * @param Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function all(Request $request)
    {
        // Start query builder
        $query = Transaction::with(['category', 'subcategory', 'account', 'currency']);

        // Exclude pending ones (unpaind recurring)
        $query->where('transaction_status','confirmed');
        
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
        $transactions = $query->orderBy('transaction_id', 'desc')->paginate(25);

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
            $q->whereNot('category_direction','+')->where('transaction_status','confirmed');
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
            $q->whereNot('category_direction','-')->where('transaction_status','confirmed');
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

    
    public function edit(Transaction $transaction) {
        // Fething data for / displaying edit form
        $categories = Category::all();
        $subcategories = Subcategory::where('category_id', $transaction->category_id)->get();
        $accounts = Account::all();
        $currencies = Currency::all();

        return view('transactions.partials.edit', compact('transaction', 'categories', 'subcategories', 'accounts', 'currencies'));
    }

    public function update(Request $request, Transaction $transaction) {
        $validated = $request->validate([
            'transaction_date_completed' => 'required|date',
            'transaction_amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'nullable|exists:subcategories,subcategory_id',
            'transaction_description' => 'nullable|string|max:255',
            'currency_id' => 'required|exists:currencies,currency_id',
            'account_id' => 'required|exists:accounts,account_id',
            'is_split' => 'boolean',
            'transaction_split_amount' => 'nullable|numeric'
        ]);

        // Manually ensure is_split false if missing from the request
        $validated['is_split'] = $request->has('is_split');

        //Fix for the null not saving issue
        $validated['subcategory_id'] = $request->input('subcategory_id') ?: null;
        $validated['transaction_description'] = $request->input('transaction_description') ?: null;
        $validated['transaction_split_amount'] = $request->input('transaction_split_amount') ?: null;

        // If it was pending mark as confirmed
        if ($transaction->transaction_status === 'pending') {
        $validated['transaction_status'] = 'confirmed';
        }

        $transaction->update($validated);

        //Redirect with success message
        if($transaction->transaction_status === 'pending') $message = 'Tranzakció jóváhagyva.';
        else $message = 'Tranzakció frissítve.';
        return redirect()->back()->with('success',$message);
    }

    public function create(){
        //Fething data for form
        $categories = Category::all();
        $subcategories = Subcategory::all();
        $accounts = Account::all();
        $currencies = Currency::all();

        return view('transactions.partials.create', compact('categories', 'subcategories', 'currencies', 'accounts'));
    }
    
    // Create new entry
    public function store(Request $request) {
        //dd($request->all());
    
        $validated = $request->validate([
            'transaction_date_completed' => 'required|date',
            'transaction_amount' => 'required|numeric',
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_id' => 'nullable|exists:subcategories,subcategory_id',
            'transaction_description' => 'nullable|string|max:255',
            'currency_id' => 'required|exists:currencies,currency_id',
            'account_id' => 'required|exists:accounts,account_id',
            'is_split' => 'boolean',
            'transaction_split_amount' => 'nullable|numeric'
        ]);

        //If no user is leggoed in, default to ID 1. (for development purposes)
        $validated['user_id'] = auth()->id() ?? 1;
        
        // Manually ensure is_split false if missing from the request
        $validated['is_split'] = $request->has('is_split');

        //Fix for the null not saving issue
        $validated['subcategory_id'] = $request->input('subcategory_id') ?: null;
        $validated['transaction_description'] = $request->input('transaction_description') ?: null;
        $validated['transaction_split_amount'] = $request->input('transaction_split_amount') ?: null;

        Transaction::create($validated);

        return redirect()->back()->with('success','Tranzakció rögzítve.');
    }

    public function destroy(Transaction $transaction) {
        $transaction->delete();

        return redirect()->back()->with('success','Tranzakció törölve.');
    }

    public function getSubcategories($categoryID) {
        $subcategories = Subcategory::where('category_id', $categoryID)->get();

        //Returning subcats belonging to a category in JSON
        return response()->json($subcategories);
    }

    // Used for recalculating completion date of recurrings approved with a delay
    public function approve(Transaction $transaction) {
        
        $transaction->update([
        'transaction_status' => 'confirmed',
        'transaction_date_completed' => now()->format('Y-m-d') 
        ]);

        return redirect()->back()->with('success', 'Tranzakció rögzítve.');
    }


    private function latest_transactions(int $number_of_entries, bool $is_expense) {
        $query = Transaction::with(['category','subcategory','currency']);

        if($is_expense)
            $query->where('transaction_amount', '<', 0);
        else
            $query->where('transaction_amount', '>', 0);

        return $query
            ->where('transaction_status','confirmed')
            ->orderBy('transaction_date_completed', 'desc')
            ->orderBy('transaction_id','desc')
            ->limit($number_of_entries)
            ->get();
    }
}