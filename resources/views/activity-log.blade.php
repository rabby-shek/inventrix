@extends('layouts.panel')

@section('title', 'Activity Log - Inventrix')
@section('page-title', 'Activity Log')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-3">
        <button class="px-4 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 shadow-sm transition-colors">All Activity</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Inventory</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Sales</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Users</button>
        <button class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-gray-50 bg-white transition-colors">Settings</button>
    </div>
    <div class="flex items-center gap-3">
        <div class="relative">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <input type="text" placeholder="Filter by date..." class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white w-48">
        </div>
        <button class="flex items-center gap-2 px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 bg-white transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
            Export
        </button>
    </div>
</div>

<div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100">
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Time</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">User</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Action</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Module</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Description</th>
                    <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">IP Address</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">2 min ago</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xs font-medium">AK</div>
                            <span class="text-sm font-medium text-gray-900">Admin</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Created</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Product</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Created new product "Wireless Keyboard Pro"</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.100</td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">15 min ago</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 text-xs font-medium">JS</div>
                            <span class="text-sm font-medium text-gray-900">John Smith</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Updated</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Stock</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Adjusted stock for SKU-001: +25 units</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.105</td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">1 hour ago</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 text-xs font-medium">SW</div>
                            <span class="text-sm font-medium text-gray-900">Sarah Wilson</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Updated</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Order</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Updated status of order ORD-1024 to "Completed"</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.112</td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">3 hours ago</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xs font-medium">AK</div>
                            <span class="text-sm font-medium text-gray-900">Admin</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-700">Deleted</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Category</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Deleted category "Old Season Items"</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.100</td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">5 hours ago</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-rose-100 rounded-full flex items-center justify-center text-rose-600 text-xs font-medium">MC</div>
                            <span class="text-sm font-medium text-gray-900">Mike Chen</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-amber-100 text-amber-700">Transferred</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Stock</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Transferred 50 units of SKU-004 to Secondary Warehouse</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.108</td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">Yesterday</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-purple-100 rounded-full flex items-center justify-center text-purple-600 text-xs font-medium">LG</div>
                            <span class="text-sm font-medium text-gray-900">Lisa Garcia</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-700">Updated</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Expense</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Approved expense EXP-2026-0089 ($450.00)</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.115</td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">Yesterday</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xs font-medium">AK</div>
                            <span class="text-sm font-medium text-gray-900">Admin</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Created</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">Purchase Order</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Created purchase order PO-2026-0042 ($12,450.00)</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.100</td>
                </tr>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 text-sm text-gray-500 whitespace-nowrap">2 days ago</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <div class="w-7 h-7 bg-indigo-100 rounded-full flex items-center justify-center text-indigo-600 text-xs font-medium">AK</div>
                            <span class="text-sm font-medium text-gray-900">Admin</span>
                        </div>
                    </td>
                    <td class="px-6 py-4"><span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-700">Created</span></td>
                    <td class="px-6 py-4 text-sm text-gray-600">User</td>
                    <td class="px-6 py-4 text-sm text-gray-500 max-w-xs truncate">Created new user account for Sarah Wilson</td>
                    <td class="px-6 py-4 text-sm font-mono text-gray-400">192.168.1.100</td>
                </tr>
            </tbody>
        </table>
    </div>
    <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
        <p class="text-sm text-gray-500">Showing 1-8 of 1,247 activities</p>
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
