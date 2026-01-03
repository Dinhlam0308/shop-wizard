<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
        <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
            Edit Metric Target
        </h2>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-4xl mx-auto px-6">
            
            {{-- Notifications --}}
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-notification type="error" :message="session('error')" />
            @endif

            {{-- Card --}}
            <div class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                        rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                        p-8 transition-all duration-500 ease-in-out">

                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6 
                           tracking-tight border-b border-gray-200 dark:border-gray-700 pb-3">
                    Edit Metric Target Details
                </h3>

                <form action="{{ route('admin.metrics_targets.update', $metricsTarget->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    {{-- Metric Name --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Metric Name
                        </label>
                        <select name="metric_name"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300">
                            @foreach (['news', 'products', 'orders', 'revenue', 'users', 'bookings', 'contacts', 'workshops', 'categories', 'menus'] as $metric)
                                <option value="{{ $metric }}" {{ old('metric_name', $metricsTarget->metric_name) == $metric ? 'selected' : '' }}>
                                    {{ ucfirst($metric) }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Monthly Goal --}}
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Monthly Goal
                        </label>
                        <input type="number" name="monthly_goal" 
                            value="{{ old('monthly_goal', $metricsTarget->monthly_goal) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="Enter monthly goal (e.g. 100)">
                    </div>

                    {{-- Actions --}}
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.metrics_targets.index') }}"
                            class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                                  hover:text-gray-900 dark:hover:text-white hover:bg-gray-100/50 
                                  dark:hover:bg-gray-700/40 transition-all duration-300">
                            Cancel
                        </a>
                        <button type="submit"  x-data="loadingButton" @click="handleClick" data-loading
                            class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-gray-900 to-gray-700 
                                   dark:from-gray-100 dark:to-gray-300 
                                   text-white dark:text-gray-900 font-semibold text-sm 
                                   shadow-lg hover:shadow-xl hover:scale-[1.02]
                                   hover:from-gray-800 hover:to-gray-600
                                   transition-all duration-300 ease-in-out">
                            Update Target
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
