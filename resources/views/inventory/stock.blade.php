@extends('layouts.panel')

@section('title', 'Stock - Inventrix')
@section('page-title', 'Stock Management')

@section('content')
<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500">Total Items</p>
            <div class="w-9 h-9 bg-indigo-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['total']) }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500">In Stock</p>
            <div class="w-9 h-9 bg-green-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['in_stock']) }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500">Low Stock</p>
            <div class="w-9 h-9 bg-yellow-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-yellow-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ number_format($stats['low_stock']) }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <div class="flex items-center justify-between mb-3">
            <p class="text-sm text-gray-500">Out of Stock</p>
            <div class="w-9 h-9 bg-red-50 rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-red-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
        </div>
        <p class="text-2xl font-bold text-gray-900">{{ $stats['out_of_stock'] }}</p>
    </div>
</div>

<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4 flex-1">
        <form method="GET" action="{{ route('inventory.stock') }}" class="relative flex-1 max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search stock..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
        </form>
        <div class="flex items-center gap-2">
            <a href="{{ route('inventory.stock') }}" class="px-4 py-2.5 {{ !request('status') ? 'border border-gray-300 text-gray-700 bg-white' : 'border border-transparent text-gray-500 bg-transparent' }} rounded-lg text-sm hover:bg-gray-50 transition-colors">All Stock</a>
            <a href="{{ route('inventory.stock', ['status' => 'low_stock']) }}" class="px-4 py-2.5 {{ request('status') === 'low_stock' ? 'border border-gray-300 text-gray-700 bg-white' : 'border border-transparent text-gray-500 bg-transparent' }} rounded-lg text-sm hover:bg-gray-50 transition-colors">Low Stock</a>
            <a href="{{ route('inventory.stock', ['status' => 'out_of_stock']) }}" class="px-4 py-2.5 {{ request('status') === 'out_of_stock' ? 'border border-gray-300 text-gray-700 bg-white' : 'border border-transparent text-gray-500 bg-transparent' }} rounded-lg text-sm hover:bg-gray-50 transition-colors">Out of Stock</a>
        </div>
    </div>
    <button onclick="document.getElementById('addStockModal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
        Add Stock
    </button>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    @if($stockItems->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 px-6">
            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">No stock items found</h3>
            <p class="text-sm text-gray-500 mb-6 text-center max-w-sm">
                @if(request('search') || request('status'))
                    No stock items match your current filters. Try adjusting your search or
                    <a href="{{ route('inventory.stock') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">clear filters</a>.
                @else
                    Get started by adding stock items to track your inventory across warehouses.
                @endif
            </p>
            @if(!request('search') && !request('status'))
                <button onclick="document.getElementById('addStockModal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Stock
                </button>
            @endif
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Warehouse</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Min Stock</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($stockItems as $item)
                        <tr class="hover:bg-gray-50 transition-colors" @if($item->status === 'out_of_stock') style="border-left: 3px solid #ef4444;" @elseif($item->status === 'low_stock') style="border-left: 3px solid #eab308;" @endif>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs font-medium">
                                        @if($item->product && $item->product->image)
                                            <img src="{{ asset('storage/' . $item->product->image) }}" alt="" class="w-10 h-10 rounded-lg object-cover">
                                        @else
                                            IMG
                                        @endif
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $item->product->name ?? 'N/A' }}</p>
                                        <p class="text-xs text-gray-500">{{ $item->product->category->name ?? '' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600 font-mono">{{ $item->product->sku ?? 'N/A' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->warehouse->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <div class="flex items-center gap-2">
                                    <div class="flex-1 max-w-24 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                        <div class="h-full bg-{{ $item->status === 'out_of_stock' ? 'red' : ($item->status === 'low_stock' ? 'yellow' : 'green') }}-500 rounded-full" style="width: {{ $item->min_stock > 0 ? min(100, ($item->quantity / $item->min_stock) * 100) : 100 }}%"></div>
                                    </div>
                                    <span class="text-sm font-medium {{ $item->status === 'out_of_stock' ? 'text-red-600' : ($item->status === 'low_stock' ? 'text-yellow-600' : 'text-gray-900') }}">{{ $item->quantity }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">{{ $item->min_stock }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $item->status === 'in_stock' ? 'green' : ($item->status === 'low_stock' ? 'yellow' : 'red') }}-100 text-{{ $item->status === 'in_stock' ? 'green' : ($item->status === 'low_stock' ? 'yellow' : 'red') }}-700">
                                    {{ $item->status === 'in_stock' ? 'In Stock' : ($item->status === 'low_stock' ? 'Low Stock' : 'Out of Stock') }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button onclick="editStock({{ $item->id }}, {{ $item->quantity }}, {{ $item->min_stock }})" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors" title="Edit Stock">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                    </button>
                                    <form method="POST" action="{{ route('inventory.stock.destroy', $item) }}" onsubmit="return confirm('Delete this stock item?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
            <p class="text-sm text-gray-500">Showing {{ $stockItems->firstItem() }}-{{ $stockItems->lastItem() }} of {{ $stockItems->total() }} items</p>
            {{ $stockItems->links() }}
        </div>
    @endif
</div>

{{-- Add Stock Modal --}}
<div id="addStockModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 max-h-[80vh] flex flex-col">
        <form method="POST" action="{{ route('inventory.stock.store') }}" class="flex flex-col max-h-[80vh]">
            @csrf
            <div class="px-6 py-5 border-b border-gray-100 shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">Add Stock</h3>
            </div>
            <div class="px-6 py-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product <span class="text-red-500">*</span></label>
                    <select name="product_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none">
                        <option value="">Select product</option>
                        @foreach(\App\Models\Product::orderBy('name')->get() as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Warehouse <span class="text-red-500">*</span></label>
                    <select name="warehouse_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none">
                        <option value="">Select warehouse</option>
                        @foreach(\App\Models\Warehouse::where('status', 'active')->orderBy('name')->get() as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                        <input type="number" name="quantity" min="0" value="0" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Min Stock <span class="text-red-500">*</span></label>
                        <input type="number" name="min_stock" min="0" value="0" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                    </div>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="document.getElementById('addStockModal').classList.add('hidden')" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 bg-white transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">Add Stock</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Stock Modal --}}
<div id="editStockModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 max-h-[80vh] flex flex-col">
        <form id="editStockForm" method="POST" action="" class="flex flex-col max-h-[80vh]">
            @csrf
            @method('PUT')
            <div class="px-6 py-5 border-b border-gray-100 shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">Edit Stock</h3>
            </div>
            <div class="px-6 py-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" id="edit_stock_quantity" name="quantity" min="0" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Min Stock <span class="text-red-500">*</span></label>
                    <input type="number" id="edit_stock_min" name="min_stock" min="0" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="document.getElementById('editStockModal').classList.add('hidden')" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 bg-white transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">Update Stock</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer-scripts')
<script>
function editStock(id, quantity, minStock) {
    document.getElementById('editStockForm').action = '{{ url("inventory/stock") }}/' + id;
    document.getElementById('edit_stock_quantity').value = quantity;
    document.getElementById('edit_stock_min').value = minStock;
    document.getElementById('editStockModal').classList.remove('hidden');
}
</script>
@endsection
