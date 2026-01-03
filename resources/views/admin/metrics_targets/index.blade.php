<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
                {{ __('Metrics Targets') }}
            </h2>
            <a href="{{ route('admin.metrics_targets.create') }}"
                class="inline-flex items-center px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 
                      text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-200 
                      bg-transparent hover:bg-gray-800 dark:hover:bg-gray-700 
                      hover:text-white hover:border-gray-800 dark:hover:border-gray-500
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 
                      transition-all duration-300 ease-in-out backdrop-blur-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifications --}}
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif
            @if (session('error'))
                <x-notification type="error" :message="session('error')" />
            @endif

            {{-- Table --}}
            <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 
                        bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl 
                        transition-all duration-500 ease-in-out">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 border-b border-gray-300 dark:border-gray-700">
                            <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">ID</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Metric Name</th>
                            <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Monthly Goal</th>
                            <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                        @forelse($metricsTargets as $target)
                            <tr class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/70 hover:shadow-md transition-all duration-300 ease-in-out cursor-pointer">
                                <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $target->id }}
                                </td>
                                <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                    {{ ucfirst($target->metric_name) }}
                                </td>
                                <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                    {{ number_format($target->monthly_goal) }}
                                </td>
                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center space-x-3">

                                        {{-- Edit --}}
                                        <a href="{{ route('admin.metrics_targets.edit', $target->id) }}"
                                            class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                                  text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400 
                                                  bg-transparent hover:bg-blue-600 dark:hover:bg-blue-500 
                                                  hover:text-white hover:border-blue-600 dark:hover:border-blue-400
                                                  focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                                  transition-all duration-300 ease-in-out">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                 viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                      d="M15.232 5.232l3.536 3.536M9 11l6-6m2 2L9 11m0 0l-6 6m6-6l6 6" />
                                            </svg>
                                            Edit
                                        </a>

                                        {{-- Delete --}}
                                        <form action="{{ route('admin.metrics_targets.destroy', $target->id) }}" method="POST"
                                            class="inline-block"
                                            onsubmit="return confirm('Are you sure you want to delete this metric target?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"  x-data="loadingButton" @click="handleClick" data-loading
                                                class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                       text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                       bg-transparent hover:bg-red-600 dark:hover:bg-red-500 
                                                       hover:text-white hover:border-red-600 dark:hover:border-red-400
                                                       focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 
                                                       transition-all duration-300 ease-in-out">
                                                <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                     viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                           a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                           m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <div class="text-gray-400 dark:text-gray-500">
                                        <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor"
                                             viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M9 17v-6a2 2 0 012-2h6m2 2v6a2 2 0 01-2 2H9a2 2 0 01-2-2z" />
                                        </svg>
                                        <p class="text-lg font-medium">No metric targets found</p>
                                        <p class="text-sm">Create a target to monitor performance metrics.</p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>
