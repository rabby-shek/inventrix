<?php

namespace App\Http\Controllers;

use App\Models\StockAdjustment;
use App\Models\StockItem;
use App\Models\Product;
use App\Models\Warehouse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StockAdjustmentController extends Controller
{
    public function index(Request $request)
    {
        $query = StockAdjustment::with(['product', 'warehouse', 'toWarehouse']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                    ->orWhere('reason', 'like', "%{$search}%")
                    ->orWhereHas('product', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        $adjustments = $query->latest()->paginate(10)->withPath(route('inventory.stock-adjustments'));

        $stats = [
            'total'    => StockAdjustment::count(),
            'additions'    => StockAdjustment::where('type', 'addition')->sum('quantity'),
            'deductions'   => StockAdjustment::where('type', 'deduction')->sum('quantity'),
            'net'          => StockAdjustment::where('type', 'addition')->sum('quantity') - StockAdjustment::where('type', 'deduction')->sum('quantity'),
        ];

        $products = Product::orderBy('name')->get();
        $warehouses = Warehouse::where('status', 'active')->orderBy('name')->get();

        return view('inventory.stock-adjustments', compact('adjustments', 'stats', 'products', 'warehouses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id'     => 'required|exists:products,id',
            'warehouse_id'   => 'required|exists:warehouses,id',
            'to_warehouse_id' => 'nullable|exists:warehouses,id',
            'type'           => 'required|in:addition,deduction,transfer',
            'quantity'       => 'required|integer|min:1',
            'reason'         => 'nullable|string|max:255',
        ]);

        if ($validated['type'] === 'transfer' && empty($validated['to_warehouse_id'])) {
            return back()->withErrors(['to_warehouse_id' => 'Destination warehouse is required for transfers.'])->withInput();
        }

        DB::transaction(function () use ($validated) {
            $adjustment = StockAdjustment::create([
                'reference'       => StockAdjustment::generateReference(),
                'product_id'      => $validated['product_id'],
                'warehouse_id'    => $validated['warehouse_id'],
                'to_warehouse_id' => $validated['to_warehouse_id'] ?? null,
                'type'            => $validated['type'],
                'quantity'        => $validated['quantity'],
                'reason'          => $validated['reason'] ?? null,
            ]);

            if ($validated['type'] === 'addition') {
                $this->updateStock($validated['product_id'], $validated['warehouse_id'], $validated['quantity']);
            } elseif ($validated['type'] === 'deduction') {
                $this->updateStock($validated['product_id'], $validated['warehouse_id'], -$validated['quantity']);
            } elseif ($validated['type'] === 'transfer') {
                $this->updateStock($validated['product_id'], $validated['warehouse_id'], -$validated['quantity']);
                $this->updateStock($validated['product_id'], $validated['to_warehouse_id'], $validated['quantity']);
            }
        });

        return redirect()->route('inventory.stock-adjustments')->with('success', 'Stock adjustment recorded successfully.');
    }

    public function destroy(StockAdjustment $stockAdjustment)
    {
        DB::transaction(function () use ($stockAdjustment) {
            if ($stockAdjustment->type === 'addition') {
                $this->updateStock($stockAdjustment->product_id, $stockAdjustment->warehouse_id, -$stockAdjustment->quantity);
            } elseif ($stockAdjustment->type === 'deduction') {
                $this->updateStock($stockAdjustment->product_id, $stockAdjustment->warehouse_id, $stockAdjustment->quantity);
            } elseif ($stockAdjustment->type === 'transfer') {
                $this->updateStock($stockAdjustment->product_id, $stockAdjustment->warehouse_id, $stockAdjustment->quantity);
                $this->updateStock($stockAdjustment->product_id, $stockAdjustment->to_warehouse_id, -$stockAdjustment->quantity);
            }

            $stockAdjustment->delete();
        });

        return redirect()->route('inventory.stock-adjustments')->with('success', 'Stock adjustment deleted and stock reverted.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:stock_adjustments,id']);

        DB::transaction(function () use ($request) {
            foreach ($request->ids as $id) {
                $adj = StockAdjustment::find($id);
                if ($adj) {
                    if ($adj->type === 'addition') {
                        $this->updateStock($adj->product_id, $adj->warehouse_id, -$adj->quantity);
                    } elseif ($adj->type === 'deduction') {
                        $this->updateStock($adj->product_id, $adj->warehouse_id, $adj->quantity);
                    } elseif ($adj->type === 'transfer') {
                        $this->updateStock($adj->product_id, $adj->warehouse_id, $adj->quantity);
                        $this->updateStock($adj->product_id, $adj->to_warehouse_id, -$adj->quantity);
                    }
                    $adj->delete();
                }
            }
        });

        return redirect()->route('inventory.stock-adjustments')->with('success', count($request->ids) . ' adjustment(s) deleted and stock reverted.');
    }

    private function updateStock(int $productId, int $warehouseId, int $delta): void
    {
        StockItem::updateOrCreate(
            ['product_id' => $productId, 'warehouse_id' => $warehouseId],
            ['quantity' => DB::raw("GREATEST(0, quantity + {$delta})")]
        );
    }
}
