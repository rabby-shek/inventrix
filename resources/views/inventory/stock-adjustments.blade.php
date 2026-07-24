@extends('layouts.panel')

@section('title', 'Stock Adjustments - Inventrix')
@section('page-title', 'Stock Adjustments')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <a href="{{ route('inventory.stock-adjustments') }}" class="px-4 py-2.5 {{ !request('type') ? 'bg-indigo-600 text-white shadow-sm' : 'border border-gray-300 text-gray-600 bg-white hover:bg-gray-50' }} rounded-lg text-sm font-medium transition-colors">All Adjustments</a>
        <a href="{{ route('inventory.stock-adjustments', ['type' => 'addition']) }}" class="px-4 py-2.5 {{ request('type') === 'addition' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-gray-300 text-gray-600 bg-white hover:bg-gray-50' }} rounded-lg text-sm font-medium transition-colors">Additions</a>
        <a href="{{ route('inventory.stock-adjustments', ['type' => 'deduction']) }}" class="px-4 py-2.5 {{ request('type') === 'deduction' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-gray-300 text-gray-600 bg-white hover:bg-gray-50' }} rounded-lg text-sm font-medium transition-colors">Deductions</a>
        <a href="{{ route('inventory.stock-adjustments', ['type' => 'transfer']) }}" class="px-4 py-2.5 {{ request('type') === 'transfer' ? 'bg-indigo-600 text-white shadow-sm' : 'border border-gray-300 text-gray-600 bg-white hover:bg-gray-50' }} rounded-lg text-sm font-medium transition-colors">Transfers</a>
    </div>
    <div class="flex items-center gap-3">
        <form method="GET" action="{{ route('inventory.stock-adjustments') }}" class="relative">
            @if(request('type'))<input type="hidden" name="type" value="{{ request('type') }}">@endif
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search adjustments..." class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white w-64">
        </form>
        <button onclick="document.getElementById('addAdjustmentModal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Adjustment
        </button>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total Adjustments</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Additions</p>
        <p class="text-2xl font-bold text-green-600 mt-1">+{{ number_format($stats['additions']) }}</p>
        <p class="text-xs text-gray-500 mt-2">Units added</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Deductions</p>
        <p class="text-2xl font-bold text-red-600 mt-1">-{{ number_format($stats['deductions']) }}</p>
        <p class="text-xs text-gray-500 mt-2">Units removed</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Net Change</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ $stats['net'] >= 0 ? '+' : '' }}{{ number_format($stats['net']) }}</p>
        <p class="text-xs {{ $stats['net'] >= 0 ? 'text-green-600' : 'text-red-600' }} mt-2">Inventory {{ $stats['net'] >= 0 ? 'increase' : 'decrease' }}</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden flex flex-col" style="max-height: 60vh;">
    @if($adjustments->isEmpty())
        <div class="flex flex-col items-center justify-center py-16 px-6">
            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">No stock adjustments found</h3>
            <p class="text-sm text-gray-500 mb-6 text-center max-w-sm">
                @if(request('search') || request('type'))
                    No adjustments match your current filters. Try adjusting your search or
                    <a href="{{ route('inventory.stock-adjustments') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">clear filters</a>.
                @else
                    Get started by recording your first stock adjustment to track inventory changes.
                @endif
            </p>
            @if(!request('search') && !request('type'))
                <button onclick="document.getElementById('addAdjustmentModal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    New Adjustment
                </button>
            @endif
        </div>
    @else
        <div class="overflow-auto flex-1">
            <table class="w-full">
                <thead class="sticky top-0 z-10">
                    <tr class="bg-gray-50 border-b border-gray-100">
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reference</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Warehouse</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reason</th>
                        <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                    @foreach($adjustments as $adj)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="px-6 py-4 text-sm font-mono font-medium text-{{ $adj->type === 'deduction' ? 'red' : 'indigo' }}-600">#{{ $adj->reference }}</td>
                            <td class="px-6 py-4 text-sm text-gray-700">{{ $adj->product->name ?? 'N/A' }}</td>
                            <td class="px-6 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $adj->type === 'addition' ? 'green' : ($adj->type === 'deduction' ? 'red' : 'blue') }}-100 text-{{ $adj->type === 'addition' ? 'green' : ($adj->type === 'deduction' ? 'red' : 'blue') }}-700">
                                    {{ ucfirst($adj->type) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-sm font-medium text-{{ $adj->type === 'addition' ? 'green' : ($adj->type === 'deduction' ? 'red' : 'blue') }}-600">
                                @if($adj->type === 'addition')
                                    +{{ $adj->quantity }}
                                @elseif($adj->type === 'deduction')
                                    -{{ $adj->quantity }}
                                @else
                                    {{ $adj->quantity }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">
                                @if($adj->type === 'transfer')
                                    {{ $adj->warehouse->name ?? 'N/A' }} → {{ $adj->toWarehouse->name ?? 'N/A' }}
                                @else
                                    {{ $adj->warehouse->name ?? 'N/A' }}
                                @endif
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $adj->reason ?: '—' }}</td>
                            <td class="px-6 py-4 text-sm text-gray-500">{{ $adj->created_at->format('M d, Y') }}</td>
                            <td class="px-6 py-4 text-right">
                                <form method="POST" action="{{ route('inventory.stock-adjustments.destroy', $adj) }}" onsubmit="return confirm('Delete this adjustment? Stock quantities will be reverted.')" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50 shrink-0">
            <p class="text-sm text-gray-500">Showing {{ $adjustments->firstItem() }}-{{ $adjustments->lastItem() }} of {{ $adjustments->total() }} adjustments</p>
            {{ $adjustments->links() }}
        </div>
    @endif
</div>

{{-- New Adjustment Modal --}}
<div id="addAdjustmentModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 max-h-[80vh] flex flex-col">
        <form method="POST" action="{{ route('inventory.stock-adjustments.store') }}" class="flex flex-col max-h-[80vh]">
            @csrf
            <div class="px-6 py-5 border-b border-gray-100 shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">New Stock Adjustment</h3>
            </div>
            <div class="px-6 py-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Type <span class="text-red-500">*</span></label>
                    <select name="type" id="adj_type" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none" onchange="toggleToWarehouse()">
                        <option value="addition">Addition</option>
                        <option value="deduction">Deduction</option>
                        <option value="transfer">Transfer</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Product <span class="text-red-500">*</span></label>
                    <select name="product_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none">
                        <option value="">Select product</option>
                        @foreach($products as $product)
                            <option value="{{ $product->id }}">{{ $product->name }} ({{ $product->sku }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1" id="warehouse_label">Warehouse <span class="text-red-500">*</span></label>
                    <select name="warehouse_id" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none">
                        <option value="">Select warehouse</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div id="to_warehouse_field" class="hidden">
                    <label class="block text-sm font-medium text-gray-700 mb-1">To Warehouse <span class="text-red-500">*</span></label>
                    <select name="to_warehouse_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none">
                        <option value="">Select destination</option>
                        @foreach($warehouses as $wh)
                            <option value="{{ $wh->id }}">{{ $wh->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" min="1" value="1" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reason</label>
                    <textarea name="reason" rows="3" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white resize-none" placeholder="e.g. Stock correction, damaged goods, supplier return..."></textarea>
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="document.getElementById('addAdjustmentModal').classList.add('hidden')" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 bg-white transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">Record Adjustment</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer-scripts')
<script>
function toggleToWarehouse() {
    var type = document.getElementById('adj_type').value;
    var field = document.getElementById('to_warehouse_field');
    var label = document.getElementById('warehouse_label');
    if (type === 'transfer') {
        field.classList.remove('hidden');
        label.textContent = 'From Warehouse';
    } else {
        field.classList.add('hidden');
        label.textContent = 'Warehouse';
    }
}
</script>
@endsection
