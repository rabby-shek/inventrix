@extends('layouts.panel')

@section('title', 'Categories - Inventrix')
@section('page-title', 'Categories')

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
                <form id="searchForm" method="GET" action="{{ route('inventory.categories') }}">
                    @if (request('status'))
                        <input type="hidden" name="status" value="{{ request('status') }}">
                    @endif
                    <input id="searchInput" type="text" name="search" value="{{ request('search') }}" autocomplete="off"
                        placeholder="Search categories..."
                        class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                </form>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('inventory.categories', array_merge(request()->query(), ['status' => 'active'])) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors border
                                    {{ request('status') === 'active' ? 'bg-emerald-600 text-white border-emerald-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-100' }}">
                    Active
                </a>
                <a href="{{ route('inventory.categories', array_merge(request()->query(), ['status' => 'inactive'])) }}"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-colors border
                                    {{ request('status') === 'inactive' ? 'bg-red-600 text-white border-red-600' : 'bg-white text-gray-600 border-gray-300 hover:bg-gray-100' }}">
                    Inactive
                </a>
                @if (request('status') || request('search'))
                    <a href="{{ route('inventory.categories') }}"
                        class="px-4 py-2 rounded-lg text-sm font-medium text-gray-500 hover:text-gray-700 hover:bg-gray-100 transition-colors">
                        Clear
                    </a>
                @endif
            </div>
        </div>
        <button onclick="openCategoryModal('{{ route('inventory.categories.store') }}', '', '', '', 'active', false)"
            class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Category
        </button>
    </div>

    <div id="bulkDeleteBar"
        class="hidden items-center justify-between mb-4 px-4 py-3 bg-red-50 border border-red-200 rounded-xl">
        <div class="flex items-center gap-3">
            <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 9v2m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <span class="text-sm font-medium text-red-800"><span id="selectedCount">0</span> selected</span>
        </div>
        <div class="flex items-center gap-2">
            <button type="button" onclick="clearSelection()"
                class="px-3 py-1.5 text-sm text-gray-600 hover:bg-white rounded-lg transition-colors cursor-pointer">Cancel</button>
            <button type="button"
                onclick="prepareBulkForm(); bulkConfirmModal.open(function() { document.getElementById('bulkDeleteForm').submit(); })"
                class="flex items-center gap-1.5 px-4 py-1.5 bg-red-600 text-white text-sm font-medium rounded-lg hover:bg-red-700 transition-colors cursor-pointer">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                </svg>
                Delete Selected
            </button>
        </div>
    </div>


    @if ($categories->isEmpty())
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="flex flex-col items-center justify-center py-16 px-6">
                <div class="w-16 h-16 bg-indigo-50 rounded-2xl flex items-center justify-center mb-4">
                    <svg class="w-8 h-8 text-indigo-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                            d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                    </svg>
                </div>
                <h3 class="text-base font-semibold text-gray-900 mb-1">No categories found</h3>
                <p class="text-sm text-gray-500 mb-6 text-center max-w-sm">
                    @if (request('search') || request('status'))
                        No categories match your current filters. Try adjusting your search or
                        <a href="{{ route('inventory.categories') }}"
                            class="text-indigo-600 hover:text-indigo-700 font-medium">clear filters</a>.
                    @else
                        Get started by creating your first product category to organize your inventory.
                    @endif
                </p>
                @if (!request('search') && !request('status'))
                    <button onclick="openCategoryModal('{{ route('inventory.categories.store') }}', '', '', '', 'active', false)"
                        class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                        Add Category
                    </button>
                @endif
            </div>
        </div>
    @else
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100">
                            <th class="w-12 px-6 py-4">
                                <input type="checkbox" id="selectAll"
                                    class="w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Name
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Slug
                            </th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Products</th>
                            <th class="text-left px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">Status
                            </th>

                            <th class="text-right px-6 py-4 text-xs font-semibold text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        @foreach ($categories as $category)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4">
                                    <input type="checkbox" name="ids[]" value="{{ $category->id }}"
                                        class="row-checkbox w-4 h-4 rounded border-gray-300 text-indigo-600 focus:ring-indigo-500 cursor-pointer">
                                </td>
                                <td class="px-6 py-4">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 uppercase bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 text-sm font-bold shrink-0">
                                            {{ substr($category->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>

                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">
                                    <p class="text-sm font-medium text-gray-900">{{ $category->slug }}</p>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-600">{{ $category->products_count }}</td>
                                <td class="px-6 py-4">
                                    <x-status-badge :status="$category->status" />
                                </td>

                                <td class="px-6 py-4 text-right">
                                    <div class="flex items-center justify-end gap-1">
                                        <button type="button"
                                            onclick='openCategoryModal("{{ route('inventory.categories.update', $category) }}", "{{ $category->name }}", "{{ $category->slug }}", "{{ $category->description }}", "{{ $category->status }}", true)'
                                            class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>
                                        </button>
                                        <button type="button"
                                            onclick="confirmModal.open(function() { document.getElementById('delete-category-{{ $category->id }}').submit(); })"
                                            class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                        </button>
                                        <form id="delete-category-{{ $category->id }}"
                                            action="{{ route('inventory.categories.destroy', $category) }}" method="POST"
                                            class="hidden">
                                            @csrf
                                            @method('DELETE')
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>

            <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
                <p class="text-sm text-gray-500">
                    Showing {{ $categories->firstItem() }}-{{ $categories->lastItem() }} of {{ $categories->total() }}
                    categories
                </p>
                <div class="flex items-center gap-2">
                    {{ $categories->links() }}
                </div>
            </div>
        </div>
    @endif


@endsection

{{-- Category Modal --}}

@section('modals')
    <x-confirm-modal id="confirmModal" title="Delete Category"
        message="Are you sure you want to delete this category? This action cannot be undone." confirmText="Delete"
        cancelText="Cancel" type="danger" />

    <x-confirm-modal id="bulkConfirmModal" title="Delete Categories"
        message="Are you sure you want to delete the selected categories? This action cannot be undone."
        confirmText="Delete All" cancelText="Cancel" type="danger" />

    <form id="bulkDeleteForm" action="{{ route('inventory.categories.bulkDelete') }}" method="POST" class="hidden">
        @csrf
        <div id="bulkIdsContainer"></div>
    </form>

    <div id="categoryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">

        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeCategoryModal()"></div>
        <form id="categoryForm" class="relative bg-white rounded-2xl shadow-xl w-full max-w-md transform transition-all"
            method="POST">

            @csrf
            @method('PUT')

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <h3 id="categoryModalTitle" class="text-base font-semibold text-gray-900">Add New Category</h3>
                    <p id="categoryModalDesc" class="text-xs text-gray-500 mt-0.5">Create a new product category.</p>
                </div>
                <button type="button" onclick="closeCategoryModal()"
                    class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors cursor-pointer">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="px-5 py-5 space-y-4">
                <div>
                    <label for="name" class="block text-sm font-medium text-gray-700 mb-1.5">Category Name <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="name" name="name" placeholder="e.g. Electronics"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="slug" class="block text-sm font-medium text-gray-700 mb-1.5">Slug <span
                            class="text-red-500">*</span></label>
                    <input type="text" id="slug" name="slug" placeholder="e.g. electronics"
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white font-mono">
                    @error('slug')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                    <textarea id="description" name="description" rows="2" placeholder="Brief description..."
                        class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white resize-none"></textarea>
                </div>

                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                    <div class="flex items-center gap-3">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="active"
                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span class="text-sm text-gray-700">Active</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="status" value="inactive"
                                class="w-4 h-4 text-indigo-600 border-gray-300 focus:ring-indigo-500">
                            <span class="text-sm text-gray-700">Inactive</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="px-5 py-3 border-t border-gray-100 bg-gray-50 flex items-center justify-end gap-3 rounded-b-2xl">
                <button type="button" onclick="closeCategoryModal()"
                    class="px-4 py-2 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-white bg-white transition-colors cursor-pointer">Cancel</button>
                <button id="categoryModalBtn" type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors cursor-pointer">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('footer-scripts')
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                openCategoryModal('{{ route('inventory.categories.store') }}', '{{ old('name') }}', '{{ old('slug') }}', '{{ old('description') }}', '{{ old('status', 'active') }}', false);
            });
        </script>
    @endif

    <script>
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

            var selectAll = document.getElementById('selectAll');
            var checkboxes = document.querySelectorAll('.row-checkbox');
            var bulkBar = document.getElementById('bulkDeleteBar');
            var countEl = document.getElementById('selectedCount');
            var bulkContainer = document.getElementById('bulkIdsContainer');
            var bulkForm = document.getElementById('bulkDeleteForm');

            function updateBulkBar() {
                var checked = document.querySelectorAll('.row-checkbox:checked');
                var n = checked.length;
                countEl.textContent = n;
                if (n > 0) {
                    bulkBar.classList.remove('hidden');
                    bulkBar.classList.add('flex');
                } else {
                    bulkBar.classList.add('hidden');
                    bulkBar.classList.remove('flex');
                }
                selectAll.checked = n === checkboxes.length && n > 0;
            }

            selectAll.addEventListener('change', function () {
                var checked = this.checked;
                checkboxes.forEach(function (cb) { cb.checked = checked; });
                updateBulkBar();
            });

            checkboxes.forEach(function (cb) {
                cb.addEventListener('change', updateBulkBar);
            });

            window.clearSelection = function () {
                checkboxes.forEach(function (cb) { cb.checked = false; });
                selectAll.checked = false;
                updateBulkBar();
            };

            window.prepareBulkForm = function () {
                bulkContainer.innerHTML = '';
                document.querySelectorAll('.row-checkbox:checked').forEach(function (cb) {
                    var input = document.createElement('input');
                    input.type = 'hidden';
                    input.name = 'ids[]';
                    input.value = cb.value;
                    bulkContainer.appendChild(input);
                });
            };
        })();
    </script>

    <script>
        function openCategoryModal(action, name, slug, description, status, isEdit) {
            var form = document.getElementById('categoryForm');
            form.setAttribute('action', action);

            if (isEdit) {
                form.querySelector('[name="_method"]').value = 'PUT';
                document.getElementById('categoryModalTitle').textContent = 'Edit Category';
                document.getElementById('categoryModalDesc').textContent = 'Update category details.';
                document.getElementById('categoryModalBtn').textContent = 'Update';
            } else {
                form.querySelector('[name="_method"]').value = 'POST';
                document.getElementById('categoryModalTitle').textContent = 'Add New Category';
                document.getElementById('categoryModalDesc').textContent = 'Create a new product category.';
                document.getElementById('categoryModalBtn').textContent = 'Create';
            }

            document.getElementById('name').value = name || '';
            document.getElementById('slug').value = slug || '';
            document.getElementById('description').value = description || '';

            var statusRadio = form.querySelector('[name="status"][value="' + (status || 'active') + '"]');
            if (statusRadio) statusRadio.checked = true;

            document.getElementById('categoryModal').classList.remove('hidden');
            document.body.classList.add('modal-blur');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.body.classList.remove('modal-blur');
        }

        document.addEventListener('keydown', function (e) {
            if (!document.getElementById('categoryModal').classList.contains('hidden') && e.key === 'Escape') closeCategoryModal();
        });
    </script>
@endsection
