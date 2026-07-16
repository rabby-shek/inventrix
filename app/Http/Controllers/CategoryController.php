<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index()
    {
        return view('inventory.categories');
    }

    public function store(Request $request)
    {
        // Validate the request data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        // Create a new category using the validated data
        Category::create($validatedData);

        // Redirect back with a success message
        return redirect()->route('inventory.categories')->with('success', 'Category created successfully.');

    }
}
