<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'category_name' => 'required|string|max:255',
            'category_direction' => 'required|in:+,-',
            'category_description' => 'nullable|string|max:255',
        ]);

        $validated['user_id'] = auth()->id();
        $validated['category_is_active'] = 1;

        Category::create($validated);

        return redirect()->route('settings.index')->with('success', 'Kategória létrehozva.');
    }

    public function destroy(Category $category)
    {
        // Ensure the user owns the category
        if ($category->user_id !== auth()->id()) {
            abort(403, 'Ehhez a művelethez nincs jogosultságod.');
        }

        // TODO: Check if there are transactions using this category
        
        $category->delete();

        return redirect()->back()->with('success', 'Kategória törölve.');
    }
}