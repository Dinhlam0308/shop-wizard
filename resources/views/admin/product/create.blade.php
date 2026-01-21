<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Add New Product
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-6">
        @if (session('success'))
            <x-notification type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-notification type="error" :message="session('error')" />
        @endif

        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Product Information</h3>

            <form action="{{ route('admin.product.store') }}" method="POST" class="space-y-6"
                enctype="multipart/form-data">
                @csrf

                <!-- Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Product Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                  bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                  focus:ring-2 focus:ring-primary focus:outline-none transition"
                        placeholder="Enter product name">
                </div>

                <!-- Description -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="4"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                     bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                     focus:ring-2 focus:ring-primary focus:outline-none transition"
                        placeholder="Write a short product description...">{{ old('description') }}</textarea>
                </div>

                {{-- ================== VARIANTS (Create - same as Edit) ================== --}}
                @php
                    $initialHasVariants = old('has_variants', 0);

                    $initialVariants = [];
                    if (old('variants_json')) {
                        $decoded = json_decode(old('variants_json'), true);
                        $initialVariants = is_array($decoded) ? $decoded : [];
                    }
                @endphp

                <div x-data="productVariantsEditor({
                    initialHasVariants: @js((int) $initialHasVariants),
                    initialVariants: @js($initialVariants),
                })" x-init="init()" class="space-y-6">
                    {{-- Hidden fields để controller nhận --}}
                    <input type="hidden" name="has_variants" :value="hasVariants ? 1 : 0">
                    <input type="hidden" name="variants_json" :value="variantsJson">

                    {{-- Toggle --}}
                    <div
                        class="rounded-2xl border border-gray-200 dark:border-gray-700 p-5 bg-white/40 dark:bg-gray-900/20">
                        <div class="flex items-start justify-between gap-4">
                            <div>
                                <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Variants (Size /
                                    Color)</p>
                                <p class="text-sm text-gray-600 dark:text-gray-300 mt-1">
                                    Nếu bật Variants: quản lý tồn kho theo từng Size + Color. Stock tổng sẽ tự cộng từ
                                    variants.
                                </p>
                            </div>

                            <div class="flex items-center gap-3">
                                <button type="button" @click="setHasVariants(false)"
                                    :class="!hasVariants ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900' :
                                        'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200'"
                                    class="px-4 py-2 rounded-xl text-sm font-semibold transition">
                                    No Variants
                                </button>

                                <button type="button" @click="setHasVariants(true)"
                                    :class="hasVariants ? 'bg-gray-900 text-white dark:bg-gray-100 dark:text-gray-900' :
                                        'bg-gray-100 dark:bg-gray-800 text-gray-700 dark:text-gray-200'"
                                    class="px-4 py-2 rounded-xl text-sm font-semibold transition">
                                    Has Variants
                                </button>
                            </div>
                        </div>

                        <template x-if="clientError">
                            <p class="mt-3 text-sm text-red-600" x-text="clientError"></p>
                        </template>
                    </div>

                    {{-- ================== PRICE & STOCK (NO VARIANTS) ================== --}}
                    <div x-show="!hasVariants" x-transition.opacity>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price
                                    ($)</label>
                                <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                           bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-primary focus:outline-none transition"
                                    placeholder="0.00">
                            </div>

                            <div>
                                <label
                                    class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Stock</label>
                                <input type="number" name="stock" value="{{ old('stock') }}"
                                    class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600
                           bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                           focus:ring-2 focus:ring-primary focus:outline-none transition"
                                    placeholder="0">
                            </div>
                        </div>
                    </div>

                    {{-- ================== VARIANTS TABLE (HAS VARIANTS) ================== --}}
                    <div x-show="hasVariants" x-transition.opacity class="space-y-4">
                        <div class="flex items-center justify-between">
                            <p class="text-sm font-semibold text-gray-900 dark:text-gray-100">Variant list</p>

                            <button type="button" @click="addVariant()"
                                class="px-4 py-2 rounded-xl text-sm font-semibold bg-gray-900 text-white
                       dark:bg-gray-100 dark:text-gray-900 transition hover:opacity-90">
                                + Add Variant
                            </button>
                        </div>

                        <div class="overflow-x-auto rounded-2xl border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full text-sm">
                                <thead class="bg-gray-100/70 dark:bg-gray-800/60">
                                    <tr class="text-left text-gray-700 dark:text-gray-200">
                                        <th class="px-4 py-3 font-semibold">Color</th>
                                        <th class="px-4 py-3 font-semibold">Size</th>
                                        <th class="px-4 py-3 font-semibold">Price ($) <span
                                                class="text-xs opacity-70">(optional)</span></th>
                                        <th class="px-4 py-3 font-semibold">Stock</th>
                                        <th class="px-4 py-3 font-semibold text-right">Action</th>
                                    </tr>
                                </thead>

                                <tbody class="bg-white/60 dark:bg-gray-900/30">
                                    <template x-for="(v, idx) in variants" :key="idx">
                                        <tr class="border-t border-gray-200 dark:border-gray-700">
                                            <td class="px-4 py-3">
                                                <input type="text" x-model.trim="v.color"
                                                    class="w-full px-3 py-2 rounded-xl border border-gray-300 dark:border-gray-600
                                           bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                                           focus:ring-2 focus:ring-primary focus:outline-none"
                                                    placeholder="e.g. Black">
                                            </td>

                                            <td class="px-4 py-3">
                                                <input type="text" x-model.trim="v.size"
                                                    class="w-full px-3 py-2 rounded-xl border border-gray-300 dark:border-gray-600
                                           bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                                           focus:ring-2 focus:ring-primary focus:outline-none"
                                                    placeholder="e.g. M">
                                            </td>

                                            <td class="px-4 py-3">
                                                <input type="number" step="0.01" x-model="v.price"
                                                    class="w-full px-3 py-2 rounded-xl border border-gray-300 dark:border-gray-600
                                           bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                                           focus:ring-2 focus:ring-primary focus:outline-none"
                                                    placeholder="(optional)">
                                            </td>

                                            <td class="px-4 py-3">
                                                <input type="number" min="0" x-model="v.stock"
                                                    class="w-full px-3 py-2 rounded-xl border border-gray-300 dark:border-gray-600
                                           bg-gray-50 dark:bg-gray-800 text-gray-900 dark:text-gray-100
                                           focus:ring-2 focus:ring-primary focus:outline-none"
                                                    placeholder="0">
                                            </td>

                                            <td class="px-4 py-3 text-right">
                                                <button type="button" @click="removeVariant(idx)"
                                                    class="px-3 py-2 rounded-xl text-sm font-semibold bg-red-600 text-white hover:opacity-90">
                                                    Remove
                                                </button>
                                            </td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>

                        <div class="text-sm text-gray-600 dark:text-gray-300">
                            <span class="font-semibold">Total stock:</span>
                            <span x-text="totalStock"></span>
                        </div>
                    </div>
                </div>

                <!-- Category -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Category</label>
                    <select name="category_id"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-primary focus:outline-none transition">
                        <option value="">-- Select Category --</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}"
                                {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Is Rental -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Is Rental</label>
                    <select name="is_rental"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-primary focus:outline-none transition">
                        <option value="0" {{ old('is_rental') == '0' ? 'selected' : '' }}>No</option>
                        <option value="1" {{ old('is_rental') == '1' ? 'selected' : '' }}>Yes</option>
                    </select>
                </div>

                <!-- Image Upload Section -->
                <div class="space-y-8">
                    {{-- Main Image --}}
                    <div x-data="productMainImageUpload({ maxMB: 5 })">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Main Product Image <span class="text-red-500">*</span>
                        </label>

                        <!-- error -->
                        <template x-if="error">
                            <p class="text-sm text-red-600 mb-2" x-text="error"></p>
                        </template>

                        <div @drop.prevent="onDrop($event)" @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false" @click="$refs.mainInput.click()"
                            :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
                            class="relative border-2 border-dashed rounded-2xl p-8 bg-gray-50 dark:bg-gray-700 cursor-pointer transition-all duration-200 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-gray-600 group">
                            <input type="file" name="main_image" x-ref="mainInput" accept="image/*"
                                class="hidden" @change="onChange($event)">

                            <!-- Preview -->
                            <template x-if="preview">
                                <div class="relative">
                                    <img :src="preview" alt="Main Product Image"
                                        class="w-full h-48 object-cover rounded-xl shadow-lg" />

                                    <button type="button" @click.stop="clear()"
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-white/90 backdrop-blur-sm hover:bg-red-500 text-gray-600 hover:text-white rounded-full flex items-center justify-center shadow-lg hover:shadow-xl transition-all duration-300 ease-out hover:scale-110 border border-gray-200/50 hover:border-red-500"
                                        title="Remove Image">
                                        <svg class="w-4 h-4 transition-transform duration-200 hover:rotate-90"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            <!-- Empty -->
                            <template x-if="!preview">
                                <div class="text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 font-medium mb-1">Upload Main Image</p>
                                    <p class="text-sm text-gray-500">PNG, JPG up to 5MB</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Gallery Images --}}
                    <div x-data="productGalleryUpload({ maxMB: 5, maxImages: 5 })">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Gallery Images (Maximum 5 images)
                        </label>

                        <!-- error -->
                        <template x-if="error">
                            <p class="text-sm text-red-600 mb-3" x-text="error"></p>
                        </template>

                        <div class="grid grid-cols-5 gap-4">
                            <template x-for="(item, index) in gallery" :key="index">
                                <div class="aspect-square">
                                    <!-- Empty slot -->
                                    <template x-if="item === null">
                                        <div @drop.prevent="onDropToSlot($event, index)"
                                            @dragover.prevent="isDragging = true"
                                            @dragleave.prevent="isDragging = false" @click="openPicker()"
                                            :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
                                            class="w-full h-full border-2 border-dashed rounded-xl bg-gray-50 dark:bg-gray-700 cursor-pointer transition-all duration-200 hover:border-blue-400 hover:bg-blue-50 dark:hover:bg-gray-600 flex flex-col items-center justify-center group">
                                            <div
                                                class="w-8 h-8 bg-gray-200 dark:bg-gray-600 rounded-full flex items-center justify-center mb-2 group-hover:bg-blue-100 transition-colors">
                                                <svg class="w-4 h-4 text-gray-400 group-hover:text-blue-500"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                                </svg>
                                            </div>
                                            <span class="text-xs text-gray-500 text-center px-1"
                                                x-text="`Image ${index + 1}`"></span>
                                        </div>
                                    </template>

                                    <!-- Preview -->
                                    <template x-if="item !== null">
                                        <div class="relative w-full h-full group">
                                            <img :src="item.url" :alt="`Gallery Image ${index + 1}`"
                                                class="w-full h-full object-cover rounded-xl shadow-md" />

                                            <button type="button" @click.stop="removeImage(index)"
                                                class="absolute -top-2 -right-2 w-6 h-6 bg-white/95 backdrop-blur-sm hover:bg-red-500 text-gray-600 hover:text-white rounded-full flex items-center justify-center shadow-md hover:shadow-lg opacity-0 group-hover:opacity-100 transition-all duration-300 ease-out hover:scale-125 border border-gray-200/50 hover:border-red-500 transform hover:rotate-90"
                                                title="Remove Image">
                                                <svg class="w-3 h-3 transition-all duration-200" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2.5" d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                            </button>
                                        </div>
                                    </template>
                                </div>
                            </template>
                        </div>

                        <input type="file" name="gallery_images[]" multiple x-ref="galleryInput" accept="image/*"
                            class="hidden" @change="onPick($event)">

                        <!-- Upload instruction -->
                        <div class="mt-4 p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl">
                            <div class="flex items-start space-x-3">
                                <div class="flex-shrink-0">
                                    <svg class="w-5 h-5 text-blue-500 mt-0.5" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                </div>
                                <div class="text-sm">
                                    <p class="text-blue-700 dark:text-blue-300 font-medium">Upload Tips:</p>
                                    <ul class="text-blue-600 dark:text-blue-400 mt-1 space-y-1">
                                        <li>• Click on any empty slot to upload images</li>
                                        <li>• Drag and drop images directly onto slots</li>
                                        <li>• Supported formats: PNG, JPG, JPEG</li>
                                        <li>• Maximum file size: 5MB per image</li>
                                        <li>• Maximum images: 5</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.product.index') }}"
                        class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                              hover:text-gray-900 dark:hover:text-white transition duration-300">
                        Cancel
                    </a>
                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-gray-900 to-gray-800 
                                   dark:from-gray-100 dark:to-gray-300 
                                   text-white dark:text-gray-900 font-semibold text-sm 
                                   shadow-md hover:shadow-lg hover:scale-[1.02] 
                                   transition-all duration-300 ease-in-out">
                        Save Product
                    </button>
                </div>
            </form>
        </div>
    </div>

</x-app-layout>
