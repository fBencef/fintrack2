<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Account;
use App\Models\Currency;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch user specific settings
        $categories = Category::where('user_id', $user->user_id)->with('subcategories')->get();
        $accounts = Account::where('user_id', $user->user_id)->get();
        $currencies = Currency::where('user_id', $user->user_id)->get();

        return view('settings.index', compact('categories', 'accounts', 'currencies'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_direction' => 'required|in:+,-',
        ]);

        //User auth
        $validated['user_id'] = auth()->id();

        Category::create($validated);

        return redirect()->back()->with('success', 'Kategória létrehozva.');
    }
}