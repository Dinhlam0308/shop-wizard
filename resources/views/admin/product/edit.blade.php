<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Edit Product
            </h2>
        </div>
    </x-slot>

    <div
        class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-4xl mx-auto px-6">
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-notification type="error" :message="session('error')" />
            @endif

            <!-- Card -->
            <div
                class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                        rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                        p-8 transition-all duration-500 ease-in-out">
                <h3
                    class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6 
                           tracking-tight border-b border-gray-200 dark:border-gray-700 pb-3">
                    Edit Product Information
                </h3>

                <form action="{{ route('admin.product.update', $match->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Product Name -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Product Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $match->name) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                  bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                      focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                      focus:outline-none transition-all duration-300"
                            placeholder="Enter product name">
                    </div>

                    <!-- Slug -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Slug
                        </label>
                        <input type="text" name="slug" value="{{ old('slug', $match->slug) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                  bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                      focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                      focus:outline-none transition-all duration-300"
                            placeholder="unique-product-slug">
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Description
                        </label>
                        <textarea name="description" rows="4"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                     bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                         focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                         focus:outline-none transition-all duration-300"
                            placeholder="Write a short product description...">{{ old('description', $match->description) }}</textarea>
                    </div>

                    <!-- Price & Stock -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Price ($)
                            </label>
                            <input type="number" step="0.01" name="price"
                                value="{{ old('price', $match->price) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                      bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                          focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                          focus:outline-none transition-all duration-300"
                                placeholder="0.00">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Stock
                            </label>
                            <input type="number" name="stock" value="{{ old('stock', $match->stock) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                      bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                          focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                          focus:outline-none transition-all duration-300"
                                placeholder="0">
                        </div>
                    </div>

                    <!-- Category -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Category
                        </label>
                        <select name="category_id"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                       focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                       focus:outline-none transition-all duration-300">
                            <option value="">-- Select Category --</option>
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}"
                                    {{ old('category_id', $match->category_id) == $category->id ? 'selected' : '' }}>
                                    {{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Is Rental -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Is Rental
                        </label>
                        <select name="is_rental"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                       focus:border-transparent focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                       focus:outline-none transition-all duration-300">
                            <option value="0" {{ old('is_rental', $match->is_rental) == 0 ? 'selected' : '' }}>No
                            </option>
                            <option value="1" {{ old('is_rental', $match->is_rental) == 1 ? 'selected' : '' }}>Yes
                            </option>
                        </select>
                    </div>

                    <!-- Image Upload Section -->
                    <div class="space-y-8">
                        {{-- Main Image --}}
                        <div x-data="productMainImageUpload({ maxMB: 5, initialUrl: @js($match->image ?? null) })">
                            <template x-if="error">
                                <p class="text-sm text-red-600 mb-3" x-text="error"></p>
                            </template>

                            <input type="hidden" name="remove_main_image" x-ref="removeMain" value="0">

                            <div @drop.prevent="onDrop($event)" @dragover.prevent="isDragging = true"
                                @dragleave.prevent="isDragging = false" @click="$refs.mainInput.click()"
                                :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
                                class="relative border-2 border-dashed rounded-2xl p-8 bg-gray-50 dark:bg-gray-700 cursor-pointer transition-all duration-200">
                                <input type="file" name="main_image" x-ref="mainInput" accept="image/*"
                                    class="hidden" @change="onChange($event)">

                                <template x-if="preview">
                                    <div class="relative">
                                        <img :src="preview"
                                            class="w-full h-48 object-cover rounded-xl shadow-lg" />
                                        <button type="button" @click.stop="clear()"
                                            class="absolute -top-2 -right-2 w-8 h-8 bg-white/90 rounded-full">
                                            ✕
                                        </button>
                                    </div>
                                </template>

                                <template x-if="!preview">
                                    <div class="text-center">
                                        <p class="text-gray-600 dark:text-gray-300 font-medium mb-1">Upload Main Image
                                        </p>
                                        <p class="text-sm text-gray-500">PNG, JPG up to 5MB</p>
                                    </div>
                                </template>
                            </div>
                        </div>

                        {{-- Gallery Images --}}
                        <div x-data="productGalleryUpload({
                            maxMB: 5,
                            maxImages: 5,
                            initial: @js($match->images->map(fn($img) => ['url' => $img->image_url, 'id' => $img->id])->values())
                        })" x-init="init()">
                            <template x-if="error">
                                <p class="text-sm text-red-600 mb-3" x-text="error"></p>
                            </template>

                            <div class="grid grid-cols-5 gap-4">
                                <template x-for="(item, index) in gallery" :key="index">
                                    <div class="aspect-square">
                                        <template x-if="item === null">
                                            <div @drop.prevent="onDropToSlot($event, index)"
                                                @dragover.prevent="isDragging = true"
                                                @dragleave.prevent="isDragging = false" @click="openPicker()"
                                                :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
                                                class="w-full h-full border-2 border-dashed rounded-xl bg-gray-50 dark:bg-gray-700 cursor-pointer flex items-center justify-center">
                                                <span class="text-xs text-gray-500" x-text="`Image ${index+1}`"></span>
                                            </div>
                                        </template>

                                        <template x-if="item !== null">
                                            <div class="relative w-full h-full group">
                                                <img :src="item.url"
                                                    class="w-full h-full object-cover rounded-xl shadow-md" />
                                                <button type="button" @click.stop="removeImage(index)"
                                                    class="absolute -top-2 -right-2 w-6 h-6 bg-white/95 rounded-full">
                                                    ✕
                                                </button>
                                                <div x-show="item.existing"
                                                    class="absolute top-1 left-1 bg-green-500 text-white text-xs px-2 py-1 rounded-full">
                                                    Current
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </template>
                            </div>

                            <input type="file" name="gallery_images[]" multiple x-ref="galleryInput"
                                accept="image/*" class="hidden" @change="onPick($event)">

                            <input type="hidden" name="deleted_image_ids" x-ref="deletedImagesInput"
                                value="[]">
                        </div>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.product.index') }}"
                            class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                                  hover:text-gray-900 dark:hover:text-white hover:bg-gray-100/50 
                                  dark:hover:bg-gray-700/40 transition-all duration-300">
                            Cancel
                        </a>
                        <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-gray-900 to-gray-700 
                                       dark:from-gray-100 dark:to-gray-300 
                                       text-white dark:text-gray-900 font-semibold text-sm 
                                       shadow-lg hover:shadow-xl hover:scale-[1.02]
                                       hover:from-gray-800 hover:to-gray-600
                                       transition-all duration-300 ease-in-out">
                            Update Product
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
