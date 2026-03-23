<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
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
    /*    
    // 1. Fetch data from the Model
        $transactions = Transaction::with(['category', 'account','subcategory'])
            ->orderBy('transaction_date_completed', 'desc') // Newest first
            ->paginate(25); // Automatically create pagination logic

        // 2. Return the View and pass the data
        return view('transactions.all', compact('transactions'));
        */

        // 1. Start a query builder
        $query = Transaction::with(['category', 'subcategory', 'account', 'currency']);

        // 2. Filter by Search (in description)
        if ($request->filled('search')) {
            $query->where('transaction_description', 'like', '%' . $request->search . '%');
        }

        // 3. Filter by Category and Subactegory
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
            if($request->filled('subcategory_id')) {
                $query->where('subcategory_id', $request->subcategory_id);
            }
        }

        // 4. Get the data
        $transactions = $query->orderBy('transaction_date_completed', 'desc')->paginate(25);

        // Get content for the dropdown menus
        $categories = Category::all();

        if($request->filled('category_id')) {
            $subcategories = Subcategory::where('category_id', $request->category_id)->get();    
        }
        else $subcategories = Subcategory::all();

        //Returning the results of the query with variables that we might need to use in the view.
        return view('transactions.all', compact('transactions', 'categories','subcategories'));
    }
}