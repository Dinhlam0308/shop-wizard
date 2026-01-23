<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
                {{ __('Booking') }}
            </h2>
            <a href="{{ route('admin.booking.create') }}"
               class="inline-flex items-center px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 
                      text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-200 
                      bg-transparent hover:bg-gray-800 dark:hover:bg-gray-700 
                      hover:text-white hover:border-gray-800 dark:hover:border-gray-500
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 
                      transition-all duration-300 ease-in-out backdrop-blur-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="sr-only sm:not-sr-only">Create</span>
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif

            @if (session('error'))
                <x-notification type="error" :message="session('error')" />
            @endif

            <div
                class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 
                       bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl 
                       transition-all duration-500 ease-in-out">

                {{-- Search / Actions Bar --}}
                <div class="mx-4 my-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <form method="GET" action="{{ route('admin.booking.index') }}"
                              class="w-full sm:w-auto flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <div class="flex-1 sm:w-72">
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Search by Booking ID…"
                                       class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                                              bg-white/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100
                                              placeholder-gray-400 dark:placeholder-gray-500
                                              focus:ring-2 focus:ring-gray-600 focus:outline-none transition-all" />
                            </div>
                            <div class="flex gap-2">
                                <button type="submit"
                                        class="px-4 py-2 rounded-xl text-sm font-semibold text-white 
                                               bg-gray-900 dark:bg-gray-200 dark:text-gray-900 
                                               hover:scale-[1.03] transition-all duration-300">
                                    Search
                                </button>

                                @if (request('search'))
                                    <a href="{{ route('admin.booking.index') }}"
                                       class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 dark:border-gray-600
                                              text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                                              transition">
                                        ✕ Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ===================== Mobile Cards (<sm) ===================== --}}
                <div class="sm:hidden px-4 pb-4">
                    @forelse($bookings as $booking)
                        <article
                            class="mb-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80
                                   p-4 shadow-sm hover:shadow-md transition">
                            <header class="flex items-start justify-between gap-3">
                                <div>
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                        #{{ $booking->id }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                        {{ $booking->user->name ?? 'Unknown' }}
                                    </p>
                                </div>
                                {{-- Status badge --}}
                                @php
                                    $status = $booking->status;
                                    $badge = match($status) {
                                        'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                        'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        default     => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                    };
                                @endphp
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ $badge }}">
                                    {{ ucfirst($status ?? 'pending') }}
                                </span>
                            </header>

                            <dl class="mt-3 grid grid-cols-2 gap-x-4 gap-y-2 text-sm">
                                <div>
                                    <dt class="text-gray-500 dark:text-gray-400">Type</dt>
                                    <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $booking->type }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500 dark:text-gray-400">People</dt>
                                    <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $booking->people_count }}</dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500 dark:text-gray-400">Date</dt>
                                    <dd class="text-gray-900 dark:text-gray-100 font-medium">
                                        {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                    </dd>
                                </div>
                                <div>
                                    <dt class="text-gray-500 dark:text-gray-400">Time</dt>
                                    <dd class="text-gray-900 dark:text-gray-100 font-medium">{{ $booking->booking_time }}</dd>
                                </div>
                                <div class="col-span-2">
                                    <dt class="text-gray-500 dark:text-gray-400">Email</dt>
                                    <dd class="text-gray-900 dark:text-gray-100 truncate">{{ $booking->user->email ?? '-' }}</dd>
                                </div>
                            </dl>

                            <div class="mt-4 flex items-center gap-2">
                                <a href="{{ route('admin.booking.show', $booking->id) }}"
                                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600
                                          px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300
                                          hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition"
                                   aria-label="View booking #{{ $booking->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                    <span class="sr-only">View</span>
                                </a>

                                <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                   class="inline-flex items-center justify-center rounded-lg border border-blue-300 dark:border-blue-600
                                          px-3 py-2 text-xs font-medium text-blue-600 dark:text-blue-400
                                          hover:bg-blue-600 dark:hover:bg-blue-500 hover:text-white transition"
                                   aria-label="Edit booking #{{ $booking->id }}">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                                 a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    <span class="sr-only">Edit</span>
                                </a>

                                <form action="{{ route('admin.booking.destroy', $booking->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-lg border border-red-300 dark:border-red-600
                                                   px-3 py-2 text-xs font-medium text-red-600 dark:text-red-400
                                                   hover:bg-red-600 dark:hover:bg-red-500 hover:text-white transition"
                                            aria-label="Delete booking #{{ $booking->id }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                     a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4
                                                     a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        <span class="sr-only">Delete</span>
                                    </button>
                                </form>
                            </div>
                        </article>
                    @empty
                        <div class="px-2 py-10 text-center text-gray-400 dark:text-gray-500">
                            <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 9h8m-8 4h6m9 5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z" />
                            </svg>
                            <p class="text-lg font-medium">No bookings found</p>
                            <p class="text-sm">Get started by creating your first booking.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ===================== Desktop Table (sm+) ===================== --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[920px] w-full text-left border-collapse">
                            <thead>
                                <tr class="sticky top-0 z-10 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 border-b border-gray-300 dark:border-gray-700">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-24">ID</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[22%]">User</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[14%]">Type</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[22%]">Date & Time</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[10%]">People</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[12%]">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[16%]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($bookings as $booking)
                                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/70 hover:shadow-md transition-all duration-300 ease-in-out">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">#{{ $booking->id }}</td>
                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                {{ $booking->user->name ?? 'Unknown' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                                {{ $booking->user->email ?? '-' }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200 whitespace-nowrap">{{ $booking->type }}</td>
                                        <td class="px-6 py-4">
                                            <div class="text-sm font-medium text-gray-800 dark:text-gray-200 whitespace-nowrap">
                                                {{ \Carbon\Carbon::parse($booking->booking_date)->format('M d, Y') }}
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 whitespace-nowrap">{{ $booking->booking_time }}</div>
                                        </td>
                                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200 whitespace-nowrap">{{ $booking->people_count }}</td>
                                        <td class="px-6 py-4">
                                            @php
                                                $status = $booking->status;
                                                $badge = match($status) {
                                                    'confirmed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                    default     => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                };
                                            @endphp
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $badge }}">
                                                {{ ucfirst($status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.booking.show', $booking->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600
                                                          text-xs font-medium rounded-lg text-gray-700 dark:text-gray-300
                                                          hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white 
                                                          transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View
                                                </a>

                                                <a href="{{ route('admin.booking.edit', $booking->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                                          text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400 
                                                          bg-transparent hover:bg-blue-600 dark:hover:bg-blue-500 
                                                          hover:text-white transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                                                 a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.booking.destroy', $booking->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this booking?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                                   hover:bg-red-600 dark:hover:bg-red-500 hover:text-white 
                                                                   transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                  stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                                    a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4
                                                                    a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 dark:text-gray-500">
                                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 9h8m-8 4h6m9 5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12
                                                             a2 2 0 002 2h14a2 2 0 002-2z" />
                                                </svg>
                                                <p class="text-lg font-medium">No bookings found</p>
                                                <p class="text-sm">Get started by creating your first booking.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- ===================== /Desktop Table ===================== --}}
            </div>

            {{-- Pagination --}}
            <div class="mt-6 text-gray-700 dark:text-gray-300">
                {{ $bookings->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
