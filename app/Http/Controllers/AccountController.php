<?php

namespace App\Http\Controllers;

use App\Models\Account;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
            'currency_id' => 'required|exists:currencies,currency_id',
        ]);

        $validated['user_id'] = auth()->id();
        Account::create($validated);

        return back()->with('success', 'Számla létrehozva.');
    }

    public function update(Request $request, Account $account)
    {
        if ($account->user_id !== auth()->id()) abort(403, 'Ehhez a művelethez nincs jogosultságod.');

        $validated = $request->validate([
            'account_name' => 'required|string|max:255',
        ]);

        $account->update($validated);
        return back()->with('success', 'Számla frissítve.');
    }

    public function destroy(Account $account)
    {
        if ($account->user_id !== auth()->id()) {
            abort(403, 'Ehhez a művelethez nincs jogosultságod.');
        }
        
        $account->delete();

        return back()->with('success', 'Számla törölve.');
    }
}