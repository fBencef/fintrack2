<?php

namespace App\Http\Controllers;

use App\Models\Subcategory;
use Illuminate\Http\Request;

class SubcategoryController extends Controller
{
    public function store(Request $request) {
        $validated = $request->validate([
            'subcategory_name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,category_id',
            'subcategory_description' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['subcategory_is_active'] = 1;

        Subcategory::create($validated);

        return back()->with('success', 'Alkategória létrehozva.');
    }

    public function destroy(Subcategory $subcategory)
    {
        // User owns this?
        if ($subcategory->user_id !== auth()->id()) {
            abort(403, 'Ehhez a művelethez nincs jogosultságod.');
        }

        // TODO: Check if there are transactions using this subcategory
        
        $subcategory->delete();

        return redirect()->back()->with('success', 'Alkategória törölve.');
    }

    public function update(Request $request, Subcategory $subcategory)
    {
        if ($subcategory->user_id !== auth()->id()) abort(403, 'Ehhez a művelethez nincs jogosultságod.');

        $validated = $request->validate([
            'subcategory_name' => 'required|string|max:255',
            'subcategory_description' => 'nullable|string|max:255',
        ]);

        $subcategory->update($validated);
        return back()->with('success', 'Alkategória frissítve.');
    }
}