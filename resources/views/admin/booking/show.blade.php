<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 
                   bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Booking Details
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

        {{-- Booking Detail Card --}}
        <div
            class="rounded-2xl bg-white/90 dark:bg-gray-800/90 backdrop-blur-md border border-gray-200 dark:border-gray-700 
                   shadow-[0_4px_30px_rgba(0,0,0,0.1)] p-10 transition-all duration-500 hover:shadow-[0_6px_40px_rgba(0,0,0,0.15)]">

            {{-- Header --}}
            <div class="flex items-center justify-between mb-8">
                <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">
                    Booking Information
                </h3>
                <span
                    class="px-4 py-1 rounded-full text-sm font-medium 
                           {{ $booking->status === 'confirmed'
                               ? 'bg-green-100 text-green-700 dark:bg-green-800/30 dark:text-green-300'
                               : ($booking->status === 'cancelled'
                                   ? 'bg-red-100 text-red-700 dark:bg-red-800/30 dark:text-red-300'
                                   : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800/30 dark:text-yellow-300') }}">
                    {{ ucfirst($booking->status ?? 'pending') }}
                </span>
            </div>

            {{-- Customer info (responsive) --}}
            <div
                class="rounded-2xl border border-gray-200 dark:border-gray-700
         bg-white/70 dark:bg-gray-900/35 backdrop-blur
         p-5 sm:p-6 mb-6">
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
                                {{ $booking->user->name ?? 'Unknown' }}
                            </div>

                            <div class="text-sm text-gray-600 dark:text-gray-300 truncate">
                                {{ $booking->user->email ?? '—' }}
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
                            #{{ $booking->id }}
                        </div>
                    </div>
                </div>
            </div>

            {{-- Booking Info Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6 text-sm text-gray-700 dark:text-gray-300">
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">Booking Type</p>
                    <p class="mt-1 capitalize">{{ $booking->type ?? '—' }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">Booking Date</p>
                    <p class="mt-1">{{ \Carbon\Carbon::parse($booking->booking_date)->format('d/m/Y') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">Booking Time</p>
                    <p class="mt-1">{{ \Carbon\Carbon::parse($booking->booking_time)->format('H:i') }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">People Count</p>
                    <p class="mt-1">{{ $booking->people_count }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">Email</p>
                    <p class="mt-1">{{ $booking->email ?? 'N/A' }}</p>
                </div>
                <div>
                    <p class="font-semibold text-gray-900 dark:text-gray-100">Created At</p>
                    <p class="mt-1">{{ $booking->created_at->format('d/m/Y H:i') }}</p>
                </div>
            </div>

            {{-- Note Section --}}
            @if ($booking->note)
                <div class="mt-8">
                    <p class="font-semibold text-gray-900 dark:text-gray-100 mb-1">Note</p>
                    <div
                        class="rounded-xl border border-gray-200 dark:border-gray-700 bg-gray-50/60 dark:bg-gray-900/50 p-4 text-gray-700 dark:text-gray-300">
                        {{ $booking->note }}
                    </div>
                </div>
            @endif

            {{-- Action Buttons --}}
            <div class="flex justify-end mt-10 space-x-4">
                <a href="{{ route('admin.booking.index') }}"
                    class="px-5 py-2.5 rounded-xl text-sm font-medium 
                           text-gray-600 dark:text-gray-300 hover:text-gray-900 dark:hover:text-white 
                           transition duration-300">
                    ← Back
                </a>

                <a href="{{ route('admin.booking.edit', $booking->id) }}"
                    class="px-6 py-2.5 rounded-xl font-semibold text-sm 
                           bg-gradient-to-r from-gray-900 to-gray-800 text-white 
                           dark:from-gray-100 dark:to-gray-200 dark:text-gray-900 
                           shadow-md hover:shadow-lg hover:scale-[1.02] transition-all duration-300">
                    Edit Booking
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
