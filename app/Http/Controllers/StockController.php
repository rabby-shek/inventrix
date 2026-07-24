<?php

namespace App\Http\Controllers;

use App\Models\StockItem;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;

class StockController extends Controller
{
    public function index(Request $request)
    {
        $query = StockItem::with(['product', 'warehouse']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('product', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $status = $request->status;
            if ($status === 'low_stock') {
                $query->whereRaw('quantity > 0 AND quantity <= min_stock');
            } elseif ($status === 'out_of_stock') {
                $query->where('quantity', 0);
            } elseif ($status === 'in_stock') {
                $query->whereRaw('quantity > min_stock');
            }
        }

        $stockItems = $query->latest()->paginate(10)->withPath(route('inventory.stock'));

        $stats = [
            'total'      => StockItem::sum('quantity'),
            'in_stock'   => StockItem::whereRaw('quantity > min_stock')->sum('quantity'),
            'low_stock'  => StockItem::whereRaw('quantity > 0 AND quantity <= min_stock')->sum('quantity'),
            'out_of_stock' => StockItem::where('quantity', 0)->count(),
        ];

        return view('inventory.stock', compact('stockItems', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'   => 'required|exists:products,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'quantity'     => 'required|integer|min:0',
            'min_stock'    => 'required|integer|min:0',
        ]);

        StockItem::updateOrCreate(
            ['product_id' => $validated['product_id'], 'warehouse_id' => $validated['warehouse_id']],
            ['quantity' => $validated['quantity'], 'min_stock' => $validated['min_stock']]
        );

        return redirect()->route('inventory.stock')->with('success', 'Stock item created/updated successfully.');
    }

    public function update(Request $request, StockItem $stockItem)
    {
        $validated = $request->validate([
            'quantity'  => 'required|integer|min:0',
            'min_stock' => 'required|integer|min:0',
        ]);

        $stockItem->update($validated);

        return redirect()->route('inventory.stock')->with('success', 'Stock updated successfully.');
    }

    public function destroy(StockItem $stockItem)
    {
        $stockItem->delete();
        return redirect()->route('inventory.stock')->with('success', 'Stock item deleted successfully.');
    }
}
