@extends('layouts.panel')

@section('title', $warehouse->name . ' - Inventrix')
@section('page-title', 'Warehouse Details')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('inventory.warehouses') }}"
            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl font-bold text-gray-900">{{ $warehouse->name }}</h1>
        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $warehouse->status === 'active' ? 'green' : ($warehouse->status === 'maintenance' ? 'amber' : 'gray') }}-100 text-{{ $warehouse->status === 'active' ? 'green' : ($warehouse->status === 'maintenance' ? 'amber' : 'gray') }}-700">
            {{ ucfirst($warehouse->status) }}
        </span>
    </div>

    {{-- Warehouse Info --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <h3 class="text-base font-semibold text-gray-900 mb-4">Information</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div class="py-3 border-b border-gray-100">
                        <p class="text-sm text-gray-500">Address</p>
                        <p class="text-sm font-medium text-gray-900">{{ $warehouse->address }}</p>
                    </div>
                    <div class="py-3 border-b border-gray-100">
                        <p class="text-sm text-gray-500">Manager</p>
                        <p class="text-sm font-medium text-gray-900">{{ $warehouse->manager ?: 'N/A' }}</p>
                    </div>
                    <div class="py-3 border-b border-gray-100">
                        <p class="text-sm text-gray-500">Capacity</p>
                        <p class="text-sm font-medium text-gray-900">{{ number_format($warehouse->capacity ?? 0) }}</p>
                    </div>
                    <div class="py-3 border-b border-gray-100">
                        <p class="text-sm text-gray-500">Occupied</p>
                        <p class="text-sm font-medium text-gray-900">{{ number_format($warehouse->occupied) }} ({{ $warehouse->occupancy_percent }}%)</p>
                    </div>
                </div>
                <div class="mt-4">
                    <div class="w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-{{ $warehouse->occupancy_percent > 80 ? 'red' : ($warehouse->occupancy_percent > 50 ? 'amber' : 'blue') }}-500 rounded-full" style="width: {{ $warehouse->occupancy_percent }}%"></div>
                    </div>
                    <p class="text-xs text-gray-500 mt-1">{{ $warehouse->available }} units available</p>
                </div>
            </div>
        </div>

        <div class="space-y-4">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-sm text-gray-500">Total Products</p>
                <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total_products'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-sm text-gray-500">Total Units</p>
                <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stats['total_units']) }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-sm text-gray-500">Low Stock Items</p>
                <p class="text-2xl font-bold text-amber-600 mt-1">{{ $stats['low_stock'] }}</p>
            </div>
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <p class="text-sm text-gray-500">Out of Stock</p>
                <p class="text-2xl font-bold text-red-600 mt-1">{{ $stats['out_of_stock'] }}</p>
            </div>
        </div>
    </div>

    {{-- Stock Levels --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
        <div class="p-6 pb-4">
            <h3 class="text-base font-semibold text-gray-900">Stock in this Warehouse</h3>
        </div>

        @if ($stockItems->isEmpty())
            <div class="text-center py-12 px-6">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">No stock items in this warehouse yet</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">SKU</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Min Stock</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($stockItems as $item)
                            @php
                                $status = $item->getStatusAttribute();
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors" @if($status === 'out_of_stock') style="border-left: 3px solid #ef4444;" @elseif($status === 'low_stock') style="border-left: 3px solid #eab308;" @endif>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400 text-xs font-medium shrink-0 overflow-hidden">
                                            @if ($item->product && $item->product->image)
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
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="flex-1 max-w-24 h-1.5 bg-gray-200 rounded-full overflow-hidden">
                                            <div class="h-full bg-{{ $status === 'out_of_stock' ? 'red' : ($status === 'low_stock' ? 'yellow' : 'green') }}-500 rounded-full" style="width: {{ $item->min_stock > 0 ? min(100, ($item->quantity / $item->min_stock) * 100) : 100 }}%"></div>
                                        </div>
                                        <span class="text-sm font-medium {{ $status === 'out_of_stock' ? 'text-red-600' : ($status === 'low_stock' ? 'text-yellow-600' : 'text-gray-900') }}">{{ $item->quantity }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $item->min_stock }}</td>
                                <td class="px-6 py-4">
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $status === 'in_stock' ? 'green' : ($status === 'low_stock' ? 'yellow' : 'red') }}-100 text-{{ $status === 'in_stock' ? 'green' : ($status === 'low_stock' ? 'yellow' : 'red') }}-700">
                                        {{ $status === 'in_stock' ? 'In Stock' : ($status === 'low_stock' ? 'Low Stock' : 'Out of Stock') }}
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>

    {{-- Recent Activity --}}
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="p-6 pb-4">
            <div class="flex items-center justify-between">
                <h3 class="text-base font-semibold text-gray-900">Recent Activity</h3>
                <a href="{{ route('inventory.stock-adjustments') }}" class="text-sm text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
            </div>
        </div>

        @if ($recentAdjustments->isEmpty())
            <div class="text-center py-12 px-6">
                <div class="w-12 h-12 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                </div>
                <p class="text-sm text-gray-500">No recent activity for this warehouse</p>
            </div>
        @else
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="border-b border-gray-100 bg-gray-50">
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Reference</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Quantity</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Details</th>
                            <th class="text-left px-6 py-3 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($recentAdjustments as $adj)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-3 text-sm font-mono text-gray-600">#{{ $adj->reference }}</td>
                                <td class="px-6 py-3 text-sm text-gray-700">{{ $adj->product->name ?? 'N/A' }}</td>
                                <td class="px-6 py-3">
                                    @if ($adj->type === 'addition')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Addition</span>
                                    @elseif ($adj->type === 'deduction')
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Deduction</span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Transfer</span>
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-sm font-medium {{ $adj->type === 'addition' ? 'text-emerald-600' : ($adj->type === 'deduction' ? 'text-red-600' : 'text-blue-600') }}">
                                    @if ($adj->warehouse_id == $warehouse->id && $adj->type === 'transfer')
                                        -{{ $adj->quantity }}
                                    @elseif ($adj->to_warehouse_id == $warehouse->id && $adj->type === 'transfer')
                                        +{{ $adj->quantity }}
                                    @elseif ($adj->type === 'addition')
                                        +{{ $adj->quantity }}
                                    @else
                                        -{{ $adj->quantity }}
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-500">
                                    @if ($adj->type === 'transfer')
                                        @if ($adj->warehouse_id == $warehouse->id)
                                            To: {{ $adj->toWarehouse->name ?? 'N/A' }}
                                        @else
                                            From: {{ $adj->warehouse->name ?? 'N/A' }}
                                        @endif
                                    @else
                                        {{ $adj->reason ?: '—' }}
                                    @endif
                                </td>
                                <td class="px-6 py-3 text-sm text-gray-500">{{ $adj->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-3 border-t border-gray-100 bg-gray-50">
                {{ $recentAdjustments->links() }}
            </div>
        @endif
    </div>
@endsection
