<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\CategorySize;

class CategorySizeController extends Controller
{
    public function show(Category $category)
    {
        return view('categories.sizes', compact('category'));
    }

    public function store(Request $request, Category $category)
    {
        $request->validate([
            'size' => 'required|string|max:255',
        ]);

        $category->sizes()->create([
            'size' => $request->size,
        ]);

        return back()->with('success', 'Size added');
    }
}