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
                <input type="text" placeholder="Search categories..."
                    class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
            </div>
        </div>
        <button onclick="openCategoryModal()"
            class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
            </svg>
            Add Category
        </button>
    </div>


    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full">
                <thead>
                    <tr class="bg-gray-50 border-b border-gray-100">
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
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-indigo-50 rounded-lg flex items-center justify-center text-indigo-600 text-sm font-bold shrink-0">
                                        N</div>
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">{{ $category->name }}</p>

                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">
                                <p class="text-sm font-medium text-gray-900">{{ $category->slug }}</p>
                            </td>
                            <td class="px-6 py-4 text-sm text-gray-600">0</td>
                            <td class="px-6 py-4">
                                <x-status-badge :status="$category->status" />
                            </td>

                            <td class="px-6 py-4 text-right">
                                <div class="flex items-center justify-end gap-1">
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-gray-600 hover:bg-gray-100 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>
                                    </button>
                                    <button
                                        class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition-colors">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @endforeach


                </tbody>
            </table>
        </div>

        <div class="flex items-center justify-between px-6 py-4 border-t border-gray-100 bg-gray-50">
            <p class="text-sm text-gray-500">Showing 1-5 of 18 brands</p>
            <div class="flex items-center gap-2">
                <button
                    class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-white bg-white transition-colors disabled:opacity-50"
                    disabled>Previous</button>
                <button class="px-3 py-1.5 bg-indigo-600 text-white rounded-lg text-sm font-medium">1</button>
                <button
                    class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-white bg-white transition-colors">2</button>
                <button
                    class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-white bg-white transition-colors">3</button>
                <button
                    class="px-3 py-1.5 border border-gray-300 rounded-lg text-sm text-gray-600 hover:bg-white bg-white transition-colors">Next</button>
            </div>
        </div>
    </div>



@endsection

{{-- Category Modal --}}

@section('modals')
    <div id="categoryModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">

        <div class="fixed inset-0 bg-gray-900/40 backdrop-blur-sm transition-opacity" onclick="closeCategoryModal()"></div>
        <form class="relative bg-white rounded-2xl shadow-xl w-full max-w-md transform transition-all"
            action="{{ route('inventory.categories.store') }}" method="POST">

            @csrf

            <div class="flex items-center justify-between px-5 py-4 border-b border-gray-100">
                <div>
                    <h3 class="text-base font-semibold text-gray-900">Add New Category</h3>
                    <p class="text-xs text-gray-500 mt-0.5">Create a new product category.</p>
                </div>
                <button onclick="closeCategoryModal()"
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
                            <input type="radio" name="status" value="active" checked
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
                <button type="submit"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors cursor-pointer">Create</button>
            </div>
        </form>
    </div>
@endsection

@section('footer-scripts')
    @if ($errors->any())
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                openCategoryModal();
            });
        </script>
    @endif

    <script>
        function openCategoryModal() {
            document.getElementById('categoryModal').classList.remove('hidden');
            document.body.classList.add('modal-blur');
        }

        function closeCategoryModal() {
            document.getElementById('categoryModal').classList.add('hidden');
            document.body.classList.remove('modal-blur');
        }

        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') closeCategoryModal();
        });
    </script>
@endsection
