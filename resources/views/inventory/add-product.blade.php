@extends('layouts.panel')

@section('title', isset($product) ? 'Edit Product - Inventrix' : 'Add Product - Inventrix')
@section('page-title', isset($product) ? 'Edit Product' : 'Add Product')

@section('content')
<div class="max-w-full mx-auto">
    <div class="mb-6">
        <a href="{{ route('inventory.products') }}" class="inline-flex items-center gap-2 text-sm text-gray-500 hover:text-gray-700 transition-colors">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back to Products
        </a>
    </div>

    <form id="productForm" method="POST" action="{{ isset($product) ? route('inventory.products.update', $product) : route('inventory.products.store') }}" enctype="multipart/form-data">
        @csrf
        @if (isset($product))
            @method('PUT')
        @endif

        {{-- Product Information --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden mb-6">
            <div class="px-6 py-5 border-b border-gray-100">
                <h3 class="text-base font-semibold text-gray-900">Product Information</h3>
                <p class="text-xs text-gray-500 mt-0.5">{{ isset($product) ? 'Update the product details.' : 'Fill in the details to add a new product.' }}</p>
            </div>
            <div class="px-6 py-6 space-y-6">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Name <span class="text-red-500">*</span></label>
                        <input type="text" name="name" value="{{ old('name', $product->name ?? '') }}" placeholder="e.g. Wireless Headphones" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                        @error('name')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">SKU <span class="text-red-500">*</span></label>
                        <input type="text" name="sku" value="{{ old('sku', $product->sku ?? '') }}" placeholder="e.g. SKU-001" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white font-mono">
                        @error('sku')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Category <span class="text-red-500">*</span></label>
                        <select name="category_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white appearance-none">
                            <option value="">Select category</option>
                           @foreach ($categories as $category)
                           <option value="{{ $category->id }}" {{ old('category_id', $product->category_id ?? '') == $category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                           @endforeach
                        </select>
                        @error('category_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Brand</label>
                        <select name="brand_id" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white appearance-none">
                            <option value="">Select brand</option>
                            @foreach ($brands as $brand)
                            <option value="{{ $brand->id }}" {{ old('brand_id', $product->brand_id ?? '') == $brand->id ? 'selected' : '' }}>{{ $brand->name }}</option>
                            @endforeach
                        </select>
                        @error('brand_id')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Status</label>
                        <select name="status" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white appearance-none">
                            <option value="active" {{ old('status', $product->status ?? 'active') === 'active' ? 'selected' : '' }}>Active</option>
                            <option value="inactive" {{ old('status', $product->status ?? '') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                        @error('status')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Selling Price <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">$</span>
                            <input type="number" name="selling_price" value="{{ old('selling_price', $product->selling_price ?? '') }}" step="0.01" placeholder="0.00" class="w-full pl-7 pr-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                        </div>
                        @error('selling_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Cost Price</label>
                        <div class="relative">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-gray-400">$</span>
                            <input type="number" name="cost_price" value="{{ old('cost_price', $product->cost_price ?? '') }}" step="0.01" placeholder="0.00" class="w-full pl-7 pr-3.5 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                        </div>
                        @error('cost_price')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Minimum Stock Level</label>
                        <input type="number" name="min_stock" value="{{ old('min_stock', $product->min_stock ?? '') }}" placeholder="0" class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white">
                        @error('min_stock')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Description</label>
                        <textarea name="description" rows="3" placeholder="Product description..." class="w-full px-4 py-2.5 border border-gray-300 rounded-lg text-sm focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500 outline-none transition-colors bg-white resize-none">{{ old('description', $product->description ?? '') }}</textarea>
                        @error('description')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-gray-700 mb-1.5">Product Image</label>
                        <input type="file" id="imageInput" name="image" accept="image/*" class="hidden">
                        <div id="uploadArea" class="border-2 border-dashed border-gray-200 rounded-xl p-6 text-center hover:border-indigo-300 hover:bg-indigo-50/30 transition-colors cursor-pointer">
                            <div id="uploadPlaceholder" class="{{ isset($product) && $product->image ? 'hidden' : '' }}">
                                <svg class="w-10 h-10 text-gray-300 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                                <p class="text-sm font-medium text-gray-500">Click to upload or drag and drop</p>
                                <p class="text-xs text-gray-400 mt-0.5">PNG, JPG, GIF up to 2MB</p>
                            </div>
                            <div id="imagePreview" class="{{ isset($product) && $product->image ? '' : 'hidden' }} relative">
                                <img id="previewImg" src="{{ isset($product) && $product->image ? asset('storage/' . $product->image) : '' }}" alt="Preview" class="mx-auto max-h-48 rounded-lg object-cover">
                                <button type="button" id="removeImage" class="absolute top-2 right-2 p-1.5 bg-white rounded-full shadow-md text-gray-400 hover:text-red-500 hover:bg-red-50 transition-colors cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                                </button>
                                <p id="fileName" class="text-xs text-gray-500 mt-2">{{ isset($product) && $product->image ? basename($product->image) : '' }}</p>
                            </div>
                        </div>
                        @error('image')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('inventory.products') }}" class="px-5 py-2.5 border border-gray-300 rounded-lg text-sm text-gray-700 hover:bg-white bg-white transition-colors cursor-pointer">Cancel</a>
            <button id="submitBtn" type="submit" class="flex items-center gap-2 px-5 py-2.5 bg-indigo-600 text-white rounded-lg text-sm font-medium hover:bg-indigo-700 transition-colors shadow-sm cursor-pointer">
                <svg id="submitSpinner" class="hidden animate-spin w-4 h-4" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4z"></path>
                </svg>
                <span id="submitText">{{ isset($product) ? 'Update Product' : 'Create Product' }}</span>
            </button>
        </div>
    </form>
</div>
@endsection

@section('footer-scripts')
    <script>
        (function () {
            var isEdit = {{ isset($product) ? 'true' : 'false' }};
            var form = document.getElementById('productForm');
            var submitBtn = document.getElementById('submitBtn');
            var submitSpinner = document.getElementById('submitSpinner');
            var submitText = document.getElementById('submitText');

            form.addEventListener('submit', function () {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                submitSpinner.classList.remove('hidden');
                submitText.textContent = isEdit ? 'Updating...' : 'Creating...';
            });

            var uploadArea = document.getElementById('uploadArea');
            var imageInput = document.getElementById('imageInput');
            var uploadPlaceholder = document.getElementById('uploadPlaceholder');
            var imagePreview = document.getElementById('imagePreview');
            var previewImg = document.getElementById('previewImg');
            var fileName = document.getElementById('fileName');
            var removeBtn = document.getElementById('removeImage');

            uploadArea.addEventListener('click', function (e) {
                if (e.target === removeBtn || removeBtn.contains(e.target)) return;
                imageInput.click();
            });

            imageInput.addEventListener('change', function () {
                if (this.files && this.files[0]) {
                    showPreview(this.files[0]);
                }
            });

            uploadArea.addEventListener('dragover', function (e) {
                e.preventDefault();
                uploadArea.classList.add('border-indigo-400', 'bg-indigo-50/50');
            });

            uploadArea.addEventListener('dragleave', function (e) {
                e.preventDefault();
                uploadArea.classList.remove('border-indigo-400', 'bg-indigo-50/50');
            });

            uploadArea.addEventListener('drop', function (e) {
                e.preventDefault();
                uploadArea.classList.remove('border-indigo-400', 'bg-indigo-50/50');
                var files = e.dataTransfer.files;
                if (files && files[0] && files[0].type.startsWith('image/')) {
                    imageInput.files = files;
                    showPreview(files[0]);
                }
            });

            removeBtn.addEventListener('click', function (e) {
                e.stopPropagation();
                imageInput.value = '';
                uploadPlaceholder.classList.remove('hidden');
                imagePreview.classList.add('hidden');
            });

            function showPreview(file) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    previewImg.src = e.target.result;
                    fileName.textContent = file.name + ' (' + formatSize(file.size) + ')';
                    uploadPlaceholder.classList.add('hidden');
                    imagePreview.classList.remove('hidden');
                };
                reader.readAsDataURL(file);
            }

            function formatSize(bytes) {
                if (bytes < 1024) return bytes + ' B';
                if (bytes < 1048576) return (bytes / 1024).toFixed(1) + ' KB';
                return (bytes / 1048576).toFixed(1) + ' MB';
            }
        })();
    </script>
@endsection
