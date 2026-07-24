<?php

namespace App\Http\Controllers;

use App\Models\Brands;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::with(['category', 'brand']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $products = $query->latest()->paginate(10)->withQueryString();
        return view('inventory.products', compact('products'));
    }

    public function add()
    {
        $categories = Category::latest()->get();
        $brands = Brands::latest()->get();
        return view('inventory.add-product', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'sku'          => 'required|unique:products,sku',
            'description'  => 'nullable|string|max:1000',
            'selling_price' => 'required|numeric|min:0',
            'cost_price'   => 'nullable|numeric|min:0',
            'min_stock'    => 'nullable|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'brand_id'     => 'nullable|exists:brands,id',
            'status'       => 'required|in:active,inactive',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        Product::create($validated);

        return redirect()->route('inventory.products')->with('success', 'Product added successfully!');
    }

    public function edit(Product $product)
    {
        $categories = Category::latest()->get();
        $brands = Brands::latest()->get();
        return view('inventory.add-product', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'sku'          => 'required|unique:products,sku,' . $product->id,
            'description'  => 'nullable|string|max:1000',
            'selling_price' => 'required|numeric|min:0',
            'cost_price'   => 'nullable|numeric|min:0',
            'min_stock'    => 'nullable|integer|min:0',
            'category_id'  => 'required|exists:categories,id',
            'brand_id'     => 'nullable|exists:brands,id',
            'status'       => 'required|in:active,inactive',
            'image'        => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()->route('inventory.products')->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product)
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->route('inventory.products')->with('success', 'Product deleted successfully!');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:products,id',
        ]);

        foreach ($request->ids as $id) {
            $product = Product::find($id);
            if ($product && $product->image) {
                Storage::disk('public')->delete($product->image);
            }
            Product::destroy($id);
        }

        return response()->json([
            'success' => true,
            'message' => count($request->ids) . ' product(s) deleted successfully!'
        ]);
    }
}
