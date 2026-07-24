@extends('layouts.panel')

@section('title', 'Warehouses - Inventrix')
@section('page-title', 'Warehouses')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div class="flex items-center gap-4 flex-1">
        <div class="relative flex-1 max-w-md">
            <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none"
                stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
            </svg>
            <svg id="searchSpinner"
                class="absolute right-3 top-1/2 -translate-y-1/2 w-4 h-4 text-indigo-500 animate-spin hidden"
                fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
            </svg>
            <form id="searchForm" method="GET" action="{{ route('inventory.warehouses') }}">
                @if (request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <input id="searchInput" type="text" name="search" value="{{ request('search') }}" autocomplete="off"
                    placeholder="Search warehouses..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
            </form>
        </div>
        <div class="flex items-center gap-2">
            <a href="{{ route('inventory.warehouses', array_merge(request()->query(), ['status' => 'active'])) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors border
                                {{ request('status') === 'active' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-100' }}">
                Active
            </a>
            <a href="{{ route('inventory.warehouses', array_merge(request()->query(), ['status' => 'inactive'])) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors border
                                {{ request('status') === 'inactive' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-100' }}">
                Inactive
            </a>
            <a href="{{ route('inventory.warehouses', array_merge(request()->query(), ['status' => 'maintenance'])) }}"
                class="px-4 py-2 rounded-lg text-sm font-medium transition-colors border
                                {{ request('status') === 'maintenance' ? 'bg-amber-600 text-white border-amber-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-100' }}">
                Maintenance
            </a>
            @if (request('status') || request('search'))
                <a href="{{ route('inventory.warehouses') }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                    Clear
                </a>
            @endif
        </div>
    </div>
    <button onclick="document.getElementById('addWarehouseModal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Warehouse
    </button>
</div>

<div class="grid grid-cols-1 lg:grid-cols-4 gap-6 mb-6">
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total Warehouses</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ $stats['total'] }}</p>
        <p class="text-xs text-green-600 mt-2">All operational</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Total Capacity</p>
        <p class="text-2xl font-bold text-gray-900 mt-1">{{ number_format($stats['capacity']) }}</p>
        <p class="text-xs text-gray-500 mt-2">Storage units</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Occupied</p>
        <p class="text-2xl font-bold text-blue-600 mt-1">{{ number_format($stats['occupied']) }}</p>
        <p class="text-xs text-gray-500 mt-2">Units used</p>
    </div>
    <div class="bg-white rounded-xl p-5 shadow-sm border border-gray-100">
        <p class="text-sm text-gray-500">Available</p>
        <p class="text-2xl font-bold text-green-600 mt-1">{{ number_format($stats['available']) }}</p>
        <p class="text-xs text-green-600 mt-2">{{ $stats['capacity'] > 0 ? round(($stats['available'] / $stats['capacity']) * 100) : 0 }}% free space</p>
    </div>
</div>

@if($warehouses->isEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex flex-col items-center justify-center py-16 px-6">
            <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </div>
            <h3 class="text-base font-semibold text-gray-900 mb-1">No warehouses found</h3>
            <p class="text-sm text-gray-500 mb-6 text-center max-w-sm">
                @if(request('search'))
                    No warehouses match your search. Try adjusting your search or
                    <a href="{{ route('inventory.warehouses') }}" class="text-indigo-600 hover:text-indigo-700 font-medium">clear filters</a>.
                @else
                    Get started by creating your first warehouse to manage your inventory locations.
                @endif
            </p>
            @if(!request('search'))
                <button onclick="document.getElementById('addWarehouseModal').classList.remove('hidden')" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                    Add Warehouse
                </button>
            @endif
        </div>
    </div>
@else
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        @foreach($warehouses as $warehouse)
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="p-6">
                    <div class="flex items-start justify-between mb-4">
                        <div class="w-12 h-12 bg-{{ $warehouse->status === 'active' ? 'blue' : ($warehouse->status === 'maintenance' ? 'amber' : 'gray') }}-100 rounded-xl flex items-center justify-center">
                            <svg class="w-6 h-6 text-{{ $warehouse->status === 'active' ? 'blue' : ($warehouse->status === 'maintenance' ? 'amber' : 'gray') }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                        </div>
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $warehouse->status === 'active' ? 'green' : ($warehouse->status === 'maintenance' ? 'amber' : 'gray') }}-100 text-{{ $warehouse->status === 'active' ? 'green' : ($warehouse->status === 'maintenance' ? 'amber' : 'gray') }}-700">{{ ucfirst($warehouse->status) }}</span>
                    </div>
                    <h3 class="text-lg font-semibold text-gray-900">
                        <a href="{{ route('inventory.warehouses.show', $warehouse) }}" class="hover:text-indigo-600 transition-colors">{{ $warehouse->name }}</a>
                    </h3>
                    <p class="text-sm text-gray-500 mt-1">{{ $warehouse->address }}</p>
                    <div class="mt-4 flex items-center justify-between text-sm">
                        <span class="text-gray-500">Capacity: <span class="font-medium text-gray-900">{{ number_format($warehouse->capacity ?? 0) }}</span></span>
                        <span class="text-gray-500">Occupied: <span class="font-medium text-gray-900">{{ number_format($warehouse->occupied) }} ({{ $warehouse->occupancy_percent }}%)</span></span>
                    </div>
                    <div class="mt-2 w-full h-2 bg-gray-200 rounded-full overflow-hidden">
                        <div class="h-full bg-{{ $warehouse->occupancy_percent > 80 ? 'red' : ($warehouse->occupancy_percent > 50 ? 'amber' : 'blue') }}-500 rounded-full" style="width: {{ $warehouse->occupancy_percent }}%"></div>
                    </div>
                    <div class="mt-4 pt-4 border-t border-gray-100 flex items-center justify-between text-sm">
                        <span class="text-gray-500">Manager: <span class="text-gray-700 font-medium">{{ $warehouse->manager ?: 'N/A' }}</span></span>
                        <div class="flex gap-1">
                            <a href="{{ route('inventory.warehouses.show', $warehouse) }}" class="p-1.5 text-gray-400 hover:text-indigo-600 hover:bg-indigo-50 rounded-lg transition-colors" title="View Details">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            </a>
                            <button onclick="editWarehouse({{ $warehouse->id }}, '{{ addslashes($warehouse->name) }}', '{{ addslashes($warehouse->address) }}', {{ $warehouse->capacity ?? 'null' }}, '{{ addslashes($warehouse->manager ?? '') }}', '{{ $warehouse->status }}')" class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors" title="Edit">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </button>
                            <form method="POST" action="{{ route('inventory.warehouses.destroy', $warehouse) }}" onsubmit="return confirm('Delete this warehouse?')" class="inline">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    <div class="mt-6">
        {{ $warehouses->links() }}
    </div>
@endif

{{-- Add Warehouse Modal --}}
<div id="addWarehouseModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 max-h-[80vh] flex flex-col">
        <form method="POST" action="{{ route('inventory.warehouses.store') }}" class="flex flex-col max-h-[80vh]">
            @csrf
            <div class="px-6 py-5 border-b border-gray-100 shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">Add Warehouse</h3>
            </div>
            <div class="px-6 py-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" name="name" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white" placeholder="e.g. Main Warehouse">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                    <input type="text" name="address" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white" placeholder="e.g. 123 Industrial Blvd">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                        <input type="number" name="capacity" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white" placeholder="0">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none">
                            <option value="active">Active</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Manager</label>
                    <input type="text" name="manager" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white" placeholder="Manager name">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="document.getElementById('addWarehouseModal').classList.add('hidden')" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 bg-white transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">Create Warehouse</button>
            </div>
        </form>
    </div>
</div>

{{-- Edit Warehouse Modal --}}
<div id="editWarehouseModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center">
    <div class="bg-white rounded-xl shadow-xl w-full max-w-md mx-4 max-h-[80vh] flex flex-col">
        <form id="editWarehouseForm" method="POST" action="" class="flex flex-col max-h-[80vh]">
            @csrf
            @method('PUT')
            <div class="px-6 py-5 border-b border-gray-100 shrink-0">
                <h3 class="text-lg font-semibold text-gray-900">Edit Warehouse</h3>
            </div>
            <div class="px-6 py-6 space-y-4 overflow-y-auto flex-1">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Name <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_name" name="name" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Address <span class="text-red-500">*</span></label>
                    <input type="text" id="edit_address" name="address" required class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                </div>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Capacity</label>
                        <input type="number" id="edit_capacity" name="capacity" min="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select id="edit_status" name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white appearance-none">
                            <option value="active">Active</option>
                            <option value="maintenance">Maintenance</option>
                            <option value="inactive">Inactive</option>
                        </select>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Manager</label>
                    <input type="text" id="edit_manager" name="manager" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none bg-white">
                </div>
            </div>
            <div class="px-6 py-4 border-t border-gray-100 flex items-center justify-end gap-3 shrink-0">
                <button type="button" onclick="document.getElementById('editWarehouseModal').classList.add('hidden')" class="px-4 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-gray-50 bg-white transition-colors">Cancel</button>
                <button type="submit" class="px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm">Update Warehouse</button>
            </div>
        </form>
    </div>
</div>
@endsection

@section('footer-scripts')
<script>
function editWarehouse(id, name, address, capacity, manager, status) {
    document.getElementById('editWarehouseForm').action = '{{ url("inventory/warehouses") }}/' + id;
    document.getElementById('edit_name').value = name;
    document.getElementById('edit_address').value = address;
    document.getElementById('edit_capacity').value = capacity || '';
    document.getElementById('edit_manager').value = manager;
    document.getElementById('edit_status').value = status;
    document.getElementById('editWarehouseModal').classList.remove('hidden');
}

(function () {
    var searchInput = document.getElementById('searchInput');
    var searchForm = document.getElementById('searchForm');
    var spinner = document.getElementById('searchSpinner');
    var timer;

    searchInput.addEventListener('input', function () {
        clearTimeout(timer);
        spinner.classList.remove('hidden');
        timer = setTimeout(function () {
            searchForm.submit();
        }, 400);
    });
})();
</script>
@endsection
