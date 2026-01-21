<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Edit Booking
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

            <!-- Card -->
            <div
                class="bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                        rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                        p-8 transition-all duration-500 ease-in-out">
                <h3
                    class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6 
                           tracking-tight border-b border-gray-200 dark:border-gray-700 pb-3">
                    Edit Booking Information
                </h3>

                {{-- Customer info (responsive) --}}
                <div
                    class="rounded-2xl border border-gray-200 dark:border-gray-700
         bg-white/70 dark:bg-gray-900/35 backdrop-blur
         p-5 sm:p-6">
                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
                        {{-- Left: customer --}}
                        <div class="flex items-start gap-4 min-w-0">
                            {{-- Avatar --}}
                            <div class="shrink-0 w-11 h-11 rounded-2xl
               bg-gray-900/10 dark:bg-white/10
               border border-gray-200 dark:border-gray-700
               flex items-center justify-center"
                                aria-hidden="true">
                                <span class="text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    {{ strtoupper(mb_substr($match->user->name ?? 'U', 0, 1)) }}
                                </span>
                            </div>

                            <div class="min-w-0">
                                <div class="text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                    Customer
                                </div>

                                <div
                                    class="mt-1 text-base sm:text-lg font-semibold text-gray-900 dark:text-gray-100 truncate">
                                    {{ $match->user->name ?? 'Unknown' }}
                                </div>

                                <div class="text-sm text-gray-600 dark:text-gray-300 truncate">
                                    {{ $match->user->email ?? '—' }}
                                </div>
                            </div>
                        </div>

                        {{-- Right: booking id --}}
                        <div class="sm:text-right">
                            <div class="text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400">
                                Booking ID
                            </div>

                            <div
                                class="mt-1 inline-flex items-center justify-center
                  px-3 py-1.5 rounded-xl
                  bg-gray-900 text-white
                  dark:bg-gray-100 dark:text-gray-900
                  text-sm font-semibold">
                                #{{ $match->id }}
                            </div>
                        </div>
                    </div>
                </div>

                <form action="{{ route('admin.booking.update', $match->id) }}" method="POST"
                    enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Type -->
                    <div>
                        <input type="hidden" name="user_id" value="{{ old('user_id', $match->user_id) }}">

                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Booking Type
                        </label>
                        <input type="text" name="type" value="{{ old('type', $match->type) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="e.g., Restaurant, Hotel, Event">
                    </div>

                    <!-- Date & Time -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Booking Date
                            </label>
                            <input type="date" name="booking_date"
                                value="{{ old('booking_date', $match->booking_date) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                       bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                       focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                       focus:outline-none transition-all duration-300">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                                Booking Time
                            </label>
                            <input type="time" name="booking_time"
                                value="{{ old('booking_time', $match->booking_time) }}"
                                class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                       bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                       focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                       focus:outline-none transition-all duration-300">
                        </div>
                    </div>

                    <!-- People Count -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            People Count
                        </label>
                        <input type="number" name="people_count" min="1"
                            value="{{ old('people_count', $match->people_count) }}"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="Number of people">
                    </div>

                    <!-- Note -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Note (Optional)
                        </label>
                        <textarea name="note" rows="4"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300"
                            placeholder="Special requests or comments...">{{ old('note', $match->note) }}</textarea>
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Booking Status
                        </label>
                        <select name="status"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:ring-2 focus:ring-blue-500 dark:focus:ring-blue-400 
                                   focus:outline-none transition-all duration-300">
                            <option value="pending" {{ old('status', $match->status) == 'pending' ? 'selected' : '' }}>
                                Pending</option>
                            <option value="confirmed"
                                {{ old('status', $match->status) == 'confirmed' ? 'selected' : '' }}>Confirmed</option>
                            <option value="cancelled"
                                {{ old('status', $match->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                        </select>
                    </div>

                    <!-- Actions -->
                    <div class="flex justify-end space-x-4 pt-6">
                        <a href="{{ route('admin.booking.index') }}"
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
                            Update Booking
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
