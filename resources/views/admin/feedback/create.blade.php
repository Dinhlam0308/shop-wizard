<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 
                   bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 mx-auto">
                Add New Feedback
            </h2>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto py-12 px-6">
        {{-- Notifications --}}
        @if (session('success'))
            <x-notification type="success" :message="session('success')" />
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <x-notification type="error" :message="$error" />
            @endforeach
        @endif

        {{-- Form Container --}}
        <div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md border border-gray-100 dark:border-gray-700 p-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                Feedback Information
            </h3>

            <form action="{{ route('admin.feedback.store') }}" method="POST" class="space-y-6">
                @csrf

                {{-- Name --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Name</label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-amber-400 focus:outline-none transition"
                        placeholder="Enter customer name" required>
                </div>

                {{-- Message --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Message</label>
                    <textarea name="message" rows="5"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-amber-400 focus:outline-none transition resize-none"
                        placeholder="Write feedback content..." required>{{ old('message') }}</textarea>
                </div>

                {{-- Rating --}}
                <div x-data="{ rating: {{ old('rating', 0) }} }">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Rating
                    </label>
                    <input type="hidden" name="rating" x-model="rating">
                    <div class="flex items-center gap-2">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button"
                                @click="rating = {{ $i }}"
                                :class="rating >= {{ $i }} ? 'text-amber-400' : 'text-gray-400'"
                                class="transition focus:outline-none">
                                <i data-lucide="star" class="w-6 h-6"></i>
                            </button>
                        @endfor
                        <span class="text-xs text-gray-500 dark:text-gray-400 ml-2">(Select rating)</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.feedback.index') }}"
                        class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                              hover:text-gray-900 dark:hover:text-white transition duration-300">
                        Cancel
                    </a>
                    <button type="submit"  x-data="loadingButton" @click="handleClick" data-loading
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600 
                               text-black font-semibold text-sm shadow-md hover:shadow-lg hover:scale-[1.02] 
                               transition-all duration-300 ease-in-out">
                        Save Feedback
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
