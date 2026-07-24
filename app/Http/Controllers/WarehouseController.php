<?php

namespace App\Http\Controllers;

use App\Models\Warehouse;
use Illuminate\Http\Request;

class WarehouseController extends Controller
{
    public function index(Request $request)
    {
        $warehouses = Warehouse::query()
            ->when($request->search, function ($query, $search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('address', 'like', "%{$search}%")
                    ->orWhere('manager', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withPath(route('inventory.warehouses'));

        $stats = [
            'total' => Warehouse::count(),
            'capacity' => (int) Warehouse::sum('capacity'),
            'occupied' => (int) Warehouse::sum('occupied'),
        ];
        $stats['available'] = $stats['capacity'] - $stats['occupied'];

        return view('inventory.warehouses', compact('warehouses', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'manager'  => 'nullable|string|max:255',
            'status'   => 'required|in:active,maintenance,inactive',
        ]);

        Warehouse::create($validated);

        return redirect()->route('inventory.warehouses')->with('success', 'Warehouse created successfully.');
    }

    public function update(Request $request, Warehouse $warehouse)
    {
        $validated = $request->validate([
            'name'     => 'required|string|max:255',
            'address'  => 'required|string|max:255',
            'capacity' => 'nullable|integer|min:0',
            'manager'  => 'nullable|string|max:255',
            'status'   => 'required|in:active,maintenance,inactive',
        ]);

        $warehouse->update($validated);

        return redirect()->route('inventory.warehouses')->with('success', 'Warehouse updated successfully.');
    }

    public function destroy(Warehouse $warehouse)
    {
        $warehouse->delete();
        return redirect()->route('inventory.warehouses')->with('success', 'Warehouse deleted successfully.');
    }

    public function bulkDelete(Request $request)
    {
        $request->validate(['ids' => 'required|array', 'ids.*' => 'integer|exists:warehouses,id']);

        Warehouse::whereIn('id', $request->ids)->delete();

        return redirect()->route('inventory.warehouses')->with('success', count($request->ids) . ' warehouse(s) deleted successfully.');
    }
}
