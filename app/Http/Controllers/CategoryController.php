<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::query()
            ->withCount('products')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->paginate(10)
            ->withPath(route('inventory.categories'));

        return view('inventory.categories', compact('categories'));
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

    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:categories,slug,' . $category->id,
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $category->update($validatedData);

        return redirect()->route('inventory.categories')->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('inventory.categories')->with('success', 'Category deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:categories,id']);

        Category::whereIn('id', $request->ids)->delete();

        return redirect()->route('inventory.categories')->with('success', count($request->ids) . ' categor' . (count($request->ids) === 1 ? 'y' : 'ies') . ' deleted successfully.');
    }
}
