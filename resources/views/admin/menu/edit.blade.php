<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Edit Menu Item
            </h2>
        </div>
    </x-slot>

    <div
        class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-4xl mx-auto px-6">

            {{-- Notifications --}}
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-notification type="error" :message="session('error')" />
            @endif

            {{-- Card --}}
            <div
                class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                        rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                        p-8 transition-all duration-500 ease-in-out">

                <h3
                    class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6 
                           tracking-tight border-b border-gray-200 dark:border-gray-700 pb-3">
                    Edit Menu Information
                </h3>

                <form action="{{ route('admin.menu.update', $menu->id) }}" method="POST" enctype="multipart/form-data"
                    class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Name
                        </label>
                        <input type="text" name="name" value="{{ old('name', $menu->name) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="Enter menu item name">
                    </div>

                    {{-- Description --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Description
                        </label>
                        <textarea name="description" rows="5"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="Write menu item description...">{{ old('description', $menu->description) }}</textarea>
                    </div>

                    {{-- Price --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Price ($)
                        </label>
                        <input type="number" step="0.01" name="price" value="{{ old('price', $menu->price) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="Enter price">
                    </div>

                    <div class="flex flex-wrap items-center gap-6 mt-4">
                        {{-- Special --}}
                        <label for="is_special" class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="is_special" id="is_special" value="1"
                                {{ old('is_special', $menu->is_special) ? 'checked' : '' }}
                                class="h-5 w-5 text-amber-500 focus:ring-2 focus:ring-amber-400 focus:ring-offset-1 border-gray-300 dark:border-gray-600 rounded transition-all duration-300 group-hover:scale-110 cursor-pointer" />
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-amber-400 transition-colors">
                                Mark as Special
                            </span>
                        </label>

                        {{-- Featured --}}
                        <label for="is_featured" class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="is_featured" id="is_featured" value="1"
                                {{ old('is_featured', $menu->is_featured) ? 'checked' : '' }}
                                class="h-5 w-5 text-green-500 focus:ring-2 focus:ring-green-400 focus:ring-offset-1 border-gray-300 dark:border-gray-600 rounded transition-all duration-300 group-hover:scale-110 cursor-pointer" />
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-green-400 transition-colors">
                                Mark as Featured
                            </span>
                        </label>

                        {{-- Available --}}
                        <label for="available" class="flex items-center space-x-2 cursor-pointer group">
                            <input type="checkbox" name="available" id="available" value="1"
                                {{ old('available', $menu->available) ? 'checked' : '' }}
                                class="h-5 w-5 text-blue-500 focus:ring-2 focus:ring-blue-400 focus:ring-offset-1 border-gray-300 dark:border-gray-600 rounded transition-all duration-300 group-hover:scale-110 cursor-pointer" />
                            <span
                                class="text-sm font-medium text-gray-700 dark:text-gray-300 group-hover:text-blue-400 transition-colors">
                                Available for Order
                            </span>
                        </label>
                    </div>

                    {{-- Category --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Category
                        </label>
                        <input type="text" name="category" value="{{ old('category', $menu->category) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="E.g., Drinks, Snacks, Desserts">
                    </div>

                    {{-- Menu Image (Logic chuẩn + UI đẹp, giống Featured) --}}
                    <div x-data="productMainImageUpload({ maxMB: 5, initialUrl: @js($menu->image ?? null) })">
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                            Menu Image
                        </label>

                        {{-- error --}}
                        <template x-if="error">
                            <p class="text-sm text-red-600 mb-3" x-text="error"></p>
                        </template>

                        <div @drop.prevent="onDrop($event)" @dragover.prevent="isDragging = true"
                            @dragleave.prevent="isDragging = false" @click="$refs.mainInput.click()"
                            :class="isDragging ? 'border-blue-400 bg-blue-50' : 'border-gray-300'"
                            class="relative border-2 border-dashed rounded-2xl p-8
               bg-gray-50 dark:bg-gray-700 cursor-pointer
               transition-all duration-200 hover:border-blue-400
               hover:bg-blue-50 dark:hover:bg-gray-600 group">

                            <input type="file" name="image" x-ref="mainInput" accept="image/*" class="hidden"
                                @change="onChange($event)" />

                            {{-- Preview --}}
                            <template x-if="preview">
                                <div class="relative">
                                    <img :src="preview" alt="Menu Image"
                                        class="w-full h-64 object-cover rounded-xl shadow-lg" />

                                    <button type="button" @click.stop="clear()"
                                        class="absolute -top-2 -right-2 w-8 h-8 bg-white/90 backdrop-blur-sm
                           hover:bg-red-500 text-gray-600 hover:text-white
                           rounded-full flex items-center justify-center shadow-lg
                           hover:shadow-xl transition-all duration-300 ease-out
                           hover:scale-110 border border-gray-200/50 hover:border-red-500"
                                        title="Remove Image">
                                        <svg class="w-4 h-4 transition-transform duration-200 hover:rotate-90"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                                d="M6 18L18 6M6 6l12 12" />
                                        </svg>
                                    </button>
                                </div>
                            </template>

                            {{-- Placeholder --}}
                            <template x-if="!preview">
                                <div class="text-center">
                                    <div
                                        class="w-16 h-16 mx-auto mb-4 bg-gray-200 dark:bg-gray-600
                           rounded-full flex items-center justify-center
                           group-hover:bg-blue-100 transition-colors">
                                        <svg class="w-8 h-8 text-gray-400 group-hover:text-blue-500" fill="none"
                                            stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                        </svg>
                                    </div>
                                    <p class="text-gray-600 dark:text-gray-300 font-medium mb-1">Upload Menu Image</p>
                                    <p class="text-sm text-gray-500">PNG, JPG up to 5MB</p>
                                </div>
                            </template>
                        </div>
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.menu.index') }}"
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
                            Update Menu Item
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
