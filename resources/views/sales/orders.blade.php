@extends('layouts.panel')

@section('title', 'Orders - Inventrix')
@section('page-title', 'Orders')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <button class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition-colors">All Orders</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Pending</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Processing</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Completed</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Cancelled</button>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            <input type="text" placeholder="Search orders..." class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white w-64">
        </div>
        <a href="{{ route('orders.create') }}" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            New Order
        </a>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total Orders</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">1,456</p>
        <p class="text-xs text-green-600 mt-2">+12% from last month</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Pending</p>
        <p class="text-2xl font-bold text-yellow-600 mt-1">89</p>
        <p class="text-xs text-gray-500 mt-2">Awaiting confirmation</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Processing</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">45</p>
        <p class="text-xs text-gray-500 mt-2">In fulfillment</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Revenue</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">$48,920</p>
        <p class="text-xs text-green-600 mt-2">+8% from last month</p>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="w-10 px-6 py-4">
                        <input type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500">
                    </th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Order ID</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Customer</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Items</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Total</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Date</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Payment</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"></td>
                    <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600">#ORD-1024</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-indigo-50 rounded-full flex items-center justify-center text-indigo-600 text-xs font-medium">JD</div>
                            <span class="text-sm font-medium text-gray-900">John Doe</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">3</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">$249.97</td>
                    <td class="px-6 py-4 text-sm text-gray-500">Jul 10, 2026</td>
                    <td class="px-6 py-4"><span class="text-sm text-gray-600">PayPal</span></td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Completed</span></td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"></td>
                    <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600">#ORD-1023</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-blue-50 rounded-full flex items-center justify-center text-blue-600 text-xs font-medium">JS</div>
                            <span class="text-sm font-medium text-gray-900">Jane Smith</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">5</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">$549.50</td>
                    <td class="px-6 py-4 text-sm text-gray-500">Jul 10, 2026</td>
                    <td class="px-6 py-4"><span class="text-sm text-gray-600">Credit Card</span></td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Processing</span></td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"></td>
                    <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600">#ORD-1022</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-amber-50 rounded-full flex items-center justify-center text-amber-600 text-xs font-medium">RB</div>
                            <span class="text-sm font-medium text-gray-900">Robert Brown</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">2</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">$89.98</td>
                    <td class="px-6 py-4 text-sm text-gray-500">Jul 9, 2026</td>
                    <td class="px-6 py-4"><span class="text-sm text-orange-600">Pending</span></td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-700">Pending</span></td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"></td>
                    <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600">#ORD-1021</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-emerald-50 rounded-full flex items-center justify-center text-emerald-600 text-xs font-medium">EL</div>
                            <span class="text-sm font-medium text-gray-900">Emily Lee</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">8</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">$1,299.00</td>
                    <td class="px-6 py-4 text-sm text-gray-500">Jul 9, 2026</td>
                    <td class="px-6 py-4"><span class="text-sm text-gray-600">Bank Transfer</span></td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Completed</span></td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                    </td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4"><input type="checkbox" class="w-4 h-4 text-indigo-600 border-gray-300 rounded focus:ring-indigo-500"></td>
                    <td class="px-6 py-4 text-sm font-mono font-medium text-indigo-600">#ORD-1020</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-8 h-8 bg-rose-50 rounded-full flex items-center justify-center text-rose-600 text-xs font-medium">MW</div>
                            <span class="text-sm font-medium text-gray-900">Michael Wilson</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-600">1</td>
                    <td class="px-6 py-4 text-sm font-medium text-gray-900">$49.99</td>
                    <td class="px-6 py-4 text-sm text-gray-500">Jul 8, 2026</td>
                    <td class="px-6 py-4"><span class="text-sm text-gray-600">Debit Card</span></td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Cancelled</span></td>
                    <td class="px-6 py-4 text-right">
                        <button class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg></button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
        <p class="text-sm text-gray-500">Showing 1-5 of 145 orders</p>
        <div class="flex items-center gap-2">
            <button class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 bg-white transition-colors disabled:opacity-50" disabled>Previous</button>
            <button class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-medium">1</button>
            <button class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-white bg-white transition-colors">2</button>
            <button class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-white bg-white transition-colors">3</button>
            <button class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-white bg-white transition-colors">Next</button>
        </div>
    </div>
</div>
@endsection
