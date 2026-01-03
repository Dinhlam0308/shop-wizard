<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Add New Workshop
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-6">
        {{-- Notifications --}}
        @if (session('success'))
            <x-notification type="success" :message="session('success')" />
        @endif

        @if (session('error'))
            <x-notification type="error" :message="session('error')" />
        @endif

        {{-- Form Container --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">Workshop Information</h3>

            <form action="{{ route('admin.workshop.store') }}" method="POST" class="space-y-6"
                enctype="multipart/form-data">
                @csrf

                {{-- Title --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Title <span
                            class="text-red-500">*</span></label>
                    <input type="text" name="title" value="{{ old('title') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-primary focus:outline-none transition"
                        placeholder="Enter workshop title">
                </div>

                {{-- Description --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Description</label>
                    <textarea name="description" rows="5"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-primary focus:outline-none transition"
                        placeholder="Write workshop description...">{{ old('description') }}</textarea>
                </div>

                {{-- Date --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Date</label>
                    <input type="date" name="date" value="{{ old('date') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-primary focus:outline-none transition">
                </div>

                {{-- Time --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Time</label>
                    <input type="time" name="time" value="{{ old('time') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-primary focus:outline-none transition">
                </div>

                {{-- Max Participants --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Max
                        Participants</label>
                    <input type="number" name="max_participants" min="1" value="{{ old('max_participants') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-primary focus:outline-none transition"
                        placeholder="Enter maximum number of participants">
                </div>

                {{-- Price --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Price ($)</label>
                    <input type="number" step="0.01" name="price" value="{{ old('price') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-primary focus:outline-none transition"
                        placeholder="Enter price">
                </div>

                {{-- Location --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Location</label>
                    <input type="text" name="location" value="{{ old('location') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-primary focus:outline-none transition"
                        placeholder="E.g., Coffee Studio, Room A2, etc.">
                </div>

                {{-- Workshop Image (Logic chuẩn như Featured) --}}
                <div x-data="productMainImageUpload({ maxMB: 5 })">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-3">
                        Workshop Image
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
                            @change="onChange($event)">

                        {{-- Preview --}}
                        <template x-if="preview">
                            <div class="relative">
                                <img :src="preview" alt="Workshop Image"
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
                                <p class="text-gray-600 dark:text-gray-300 font-medium mb-1">Upload Workshop Image</p>
                                <p class="text-sm text-gray-500">PNG, JPG up to 5MB</p>
                            </div>
                        </template>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.workshop.index') }}"
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
                        Save Workshop
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
