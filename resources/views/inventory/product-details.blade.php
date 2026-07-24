@extends('layouts.panel')

@section('title', $product->name . ' - Inventrix')
@section('page-title', 'Product Details')

@section('content')
    <div class="flex items-center gap-4 mb-6">
        <a href="{{ route('inventory.products') }}"
            class="p-2 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
            </svg>
        </a>
        <h1 class="text-xl font-bold text-gray-900">Product Details</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Product Info Card --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-6">
                        <div class="w-14 h-14 bg-gray-100 rounded-xl flex items-center justify-center text-gray-400 shrink-0 overflow-hidden">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}" class="w-14 h-14 rounded-xl object-cover">
                            @else
                                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                            @endif
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900">{{ $product->name }}</h2>
                            <p class="text-sm text-gray-500 font-mono">{{ $product->sku }}</p>
                        </div>
                    </div>

                    <div class="space-y-3">
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Status</span>
                            <x-status-badge :status="$product->status" />
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Selling Price</span>
                            <span class="text-sm font-semibold text-gray-900">${{ number_format($product->selling_price, 2) }}</span>
                        </div>
                        @if ($product->cost_price)
                            <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
                                <span class="text-sm text-gray-500">Cost Price</span>
                                <span class="text-sm font-medium text-gray-600">${{ number_format($product->cost_price, 2) }}</span>
                            </div>
                        @endif
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Category</span>
                            <span class="text-sm text-gray-700">{{ $product->category->name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Brand</span>
                            <span class="text-sm text-gray-700">{{ $product->brand->name ?? '-' }}</span>
                        </div>
                        <div class="flex items-center justify-between py-2.5 border-b border-gray-100">
                            <span class="text-sm text-gray-500">Min Stock Level</span>
                            <span class="text-sm text-gray-700">{{ $product->min_stock ?? '0' }}</span>
                        </div>
                        @if ($product->description)
                            <div class="py-2.5">
                                <span class="text-sm text-gray-500 block mb-1">Description</span>
                                <p class="text-sm text-gray-700">{{ $product->description }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- Stock & Adjustments --}}
        <div class="lg:col-span-2 space-y-6">
            {{-- Stock Summary Stats --}}
            <div class="grid grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                    <p class="text-2xl font-bold text-gray-900">{{ $totalStock }}</p>
                    <p class="text-xs text-gray-500 mt-1">Total Units</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                    <p class="text-2xl font-bold text-emerald-600">{{ $product->stockItems->count() }}</p>
                    <p class="text-xs text-gray-500 mt-1">Warehouses</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 text-center">
                    <p class="text-2xl font-bold text-amber-600">{{ $lowStockCount }}</p>
                    <p class="text-xs text-gray-500 mt-1">Low Stock</p>
                </div>
            </div>

            {{-- Stock by Warehouse --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 pb-3">
                    <h3 class="text-sm font-semibold text-gray-900">Stock by Warehouse</h3>
                </div>

                @if ($product->stockItems->isEmpty())
                    <div class="text-center py-10 px-6">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">No stock records yet</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50">
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Warehouse</th>
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Min</th>
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-50">
                                @foreach ($product->stockItems as $item)
                                    @php
                                        $status = $item->getStatusAttribute();
                                    @endphp
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm font-medium text-gray-900">{{ $item->warehouse->name ?? 'Unknown' }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-600">{{ $item->quantity }}</td>
                                        <td class="px-5 py-3 text-sm text-gray-500">{{ $item->min_stock }}</td>
                                        <td class="px-5 py-3">
                                            @if ($status === 'out_of_stock')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Out of Stock</span>
                                            @elseif ($status === 'low_stock')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Low Stock</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">In Stock</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            {{-- Recent Adjustments --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-5 pb-3">
                    <div class="flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-gray-900">Recent Adjustments</h3>
                        <a href="{{ route('inventory.stock-adjustments', ['product' => $product->id]) }}"
                            class="text-xs text-indigo-600 hover:text-indigo-700 font-medium">View All</a>
                    </div>
                </div>

                @if ($recentAdjustments->isEmpty())
                    <div class="text-center py-10 px-6">
                        <div class="w-10 h-10 bg-gray-100 rounded-xl flex items-center justify-center mx-auto mb-2">
                            <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                            </svg>
                        </div>
                        <p class="text-sm text-gray-500">No adjustments recorded yet</p>
                    </div>
                @else
                    <div class="overflow-x-auto">
                        <table class="w-full">
                            <thead>
                                <tr class="border-b border-gray-100 bg-gray-50">
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Ref</th>
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Type</th>
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Warehouse</th>
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Qty</th>
                                    <th class="text-left px-5 py-2.5 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                @foreach ($recentAdjustments as $adj)
                                    <tr class="hover:bg-gray-50 transition-colors">
                                        <td class="px-5 py-3 text-sm font-mono text-gray-600">#{{ $adj->reference }}</td>
                                        <td class="px-5 py-3">
                                            @if ($adj->type === 'addition')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-emerald-100 text-emerald-700">Add</span>
                                            @elseif ($adj->type === 'deduction')
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Deduct</span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Transfer</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-sm text-gray-600">
                                            @if ($adj->type === 'transfer')
                                                <span class="text-gray-700">{{ $adj->warehouse->name ?? 'N/A' }}</span>
                                                <span class="text-gray-400 mx-0.5">&rarr;</span>
                                                <span class="text-gray-700">{{ $adj->toWarehouse->name ?? 'N/A' }}</span>
                                            @else
                                                {{ $adj->warehouse->name ?? 'N/A' }}
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-sm font-medium {{ $adj->type === 'addition' ? 'text-emerald-600' : ($adj->type === 'deduction' ? 'text-red-600' : 'text-blue-600') }}">
                                            {{ $adj->type === 'addition' ? '+' : ($adj->type === 'deduction' ? '-' : '') }}{{ $adj->quantity }}
                                        </td>
                                        <td class="px-5 py-3 text-xs text-gray-400">{{ $adj->created_at->format('M d, Y') }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="px-5 py-2.5 border-t border-gray-100 bg-gray-50">
                        {{ $recentAdjustments->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
