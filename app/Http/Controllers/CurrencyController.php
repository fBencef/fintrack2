<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'currency_name' => 'required|string|max:255',
            'currency_abbreviation' => 'required|string|max:10',
            'currency_sign' => 'required|string|max:10',
            'is_default_currency' => 'boolean'
        ]);

        $validated['user_id'] = auth()->id();

        $isDefault = $request->has('is_default_currency');

        if ($isDefault) {
            // Unset previous default
            Currency::where('user_id', auth()->id())->update(['is_default_currency' => false]);
        }

        $validated['is_default_currency'] = $isDefault;

        Currency::create($validated);

        return back()->with('success', 'Pénznem rögzítve.');
    }

    public function update(Request $request, Currency $currency)
    {
        if ($currency->user_id !== auth()->id()) abort(403, 'Ehhez a művelethez nincs jogosultságod.');

        $validated = $request->validate([
            'currency_name' => 'required|string|max:255',
            'currency_abbreviation' => 'required|string|max:10',
            'currency_sign' => 'required|string|max:10',
            'is_default_currency' => 'boolean'
        ]);

        if ($request->has('is_default_currency')) {
            Currency::where('user_id', auth()->id())->update(['is_default_currency' => 0]);
        }

        $currency->update($validated);

        return back()->with('success', 'Pénznem frissítve.');
    }

    public function destroy(Currency $currency)
    {
        if ($currency->user_id !== auth()->id()) abort(403, 'Ehhez a művelethez nincs jogosultságod.');
        
        $currency->delete();

        return back()->with('success', 'Pénznem törölve.');
    }
}