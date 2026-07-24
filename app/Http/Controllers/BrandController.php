<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Brand;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        $brands = Brand::query()
            ->withCount('products')
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->paginate(10)
            ->withPath(route('inventory.brands'));

        return view('inventory.brands', compact('brands'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug',
            'description' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        Brand::create($validatedData);

        return redirect()->route('inventory.brands')->with('success', 'Brand created successfully.');
    }

    public function update(Request $request, Brand $brand)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'required|string|max:255|unique:brands,slug,' . $brand->id,
            'description' => 'nullable|string',
            'website' => 'nullable|string|max:255',
            'status' => 'required|in:active,inactive',
        ]);

        $brand->update($validatedData);

        return redirect()->route('inventory.brands')->with('success', 'Brand updated successfully.');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
        return redirect()->route('inventory.brands')->with('success', 'Brand deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:brands,id']);

        Brand::whereIn('id', $request->ids)->delete();

        return redirect()->route('inventory.brands')->with('success', count($request->ids) . ' brand' . (count($request->ids) === 1 ? '' : 's') . ' deleted successfully.');
    }
}
