<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Category;
use App\Models\Currency;
use App\Models\Subcategory;
use App\Models\RecurringTransaction;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Carbon\Carbon;
use SebastianBergmann\CodeCoverage\FileCouldNotBeWrittenException;
use function PHPUnit\Framework\isNull;

class RecurringTransactionController extends Controller
{
    public function index() {
    $recurrings = RecurringTransaction::where('user_id', auth()->id() ?? 1)
        ->with(['category', 'subcategory', 'account', 'currency'])
        ->get();

    $categories = Category::all();
    $subcategories = Subcategory::all();
    $accounts = Account::all();
    $currencies = Currency::all();

    return view('recurring.index', compact('recurrings', 'categories', 'subcategories', 'accounts', 'currencies'));
    }

    public function store(Request $request) {
    $validated = $request->validate([
        'recurring_name' => 'required|string',
        'recurring_description' => 'nullable|string|max:255',
        'recurring_amount' => 'required|numeric',
        'recurring_start_date' => 'required|date',
        'recurring_end_date' => 'nullable|date',
        'frequency_type' => 'required|in:daily,weekly,monthly,yearly',
        'frequency_intervall' => 'required|integer|min:1',
        'recurring_is_active' => 'boolean',
        'recurring_is_prediction' => 'boolean',
        'currency_id' => 'required|exists:currencies,currency_id',
        'account_id' => 'required|exists:accounts,account_id',
        'category_id' => 'required|exists:categories,category_id',
        'subcategory_id' => 'nullable|exists:subcategories,subcategory_id',
    ]);

    //If no user is leggoed in, default to ID 1. (for development purposes)
    $validated['user_id'] = auth()->id() ?? 1;

    // First execution is probably start_date
    $validated['next_execution_date'] = $request->recurring_start_date;

    //Booleans manual false if missing from request
    $validated['recurring_is_active'] = $request->has('recurring_is_active');
    $validated['recurring_is_prediction'] = $request->has('recurring_is_prediction');

    //Nullables null not saving fix
    $validated['recurring_description'] = $request->input('recurring_description') ?: null;
    $validated['recurring_end_date'] = $request->input('recurring_end_date') ?: null;
    $validated['subcategory_id'] = $request->input('subcategory_id') ?: null;


    RecurringTransaction::create($validated);

    return redirect()->back()->with('success', 'Ismétlődő tranzakció rögzítve.');
    }

    public function create() {
    $categories = Category::all();
    $subcategories = Subcategory::all();
    $accounts = Account::all();
    $currencies = Currency::all();

    return view('recurring.partials.create', compact('categories', 'subcategories', 'accounts', 'currencies'));
    } 
    
    public function processPending() {
        $today = now()->format('Y-m-d');

        //Find active recurrings with due date today
        $recurrings = RecurringTransaction::whre('recurring_is_active',true)
            ->where('next_execution_date','<=',$today)
            ->get();

        foreach ($recurrings as $recurring) {
            // Create a pending Transaction entry
            Transaction::create([
                'user_id' => $recurring->user_id,
                'transaction_date_completed' => $recurring->next_execution_date,
                'transaction_amount' => $recurring->recurring_amount,
                'category_id' => $recurring->category_id,
                'subcategory_id' => $recurring->subcategory_id,
                'currency_id' => $recurring->currency_id,
                'account_id' => $recurring->account_id,
                'transaction_description' => $recurring->recurring_description . ' Automatikusan létrehozva.',
                'transaction_status' => 'pending',
                'is_split' => false
            ]);

        //Calculate the next occurence
        $nextOccurence = match($recurring->frequency_type) {
            'daily'   => Carbon::parse($recurring->next_execution_date)->addDays($recurring->frequency_intervall),
            'weekly'  => Carbon::parse($recurring->next_execution_date)->addWeeks($recurring->frequency_intervall),
            'monthly' => Carbon::parse($recurring->next_execution_date)->addMonths($recurring->frequency_intervall),
            'yearly'  => Carbon::parse($recurring->next_execution_date)->addYears($recurring->frequency_intervall),
        };

        //Update recurring
        $recurring->update(['next_execution_date' => $nextOccurence]);
        
        }
    }
}