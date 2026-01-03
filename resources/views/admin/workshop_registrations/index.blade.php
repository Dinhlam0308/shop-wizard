<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
                {{ __('Workshop Registrations') }}
            </h2>
            <a href="{{ route('admin.workshop_registrations.create') }}"
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
            @if ($errors->any())
                <x-notification type="error" :message="$errors->first()" />
            @endif

            <div class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 
                        bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl transition-all duration-500 ease-in-out">

                {{-- Search (giữ nguyên) --}}
                <div class="mx-4 my-4 flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" action="{{ route('admin.workshop_registrations.index') }}" class="flex items-center gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by Registration ID..."
                            class="px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-white/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100
                                   placeholder-gray-400 dark:placeholder-gray-500
                                   focus:ring-2 focus:ring-gray-600 focus:outline-none transition-all w-64" />
                        <button type="submit"
                            class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gray-900 dark:bg-gray-200 
                                   dark:text-gray-900 hover:scale-[1.03] transition-all duration-300">
                            Search
                        </button>
                    </form>

                    @if (request('search'))
                        <a href="{{ route('admin.workshop_registrations.index') }}"
                           class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                            ✕ Clear Search
                        </a>
                    @endif
                </div>

                {{-- ===================== Mobile Cards (<sm) ===================== --}}
                <div class="sm:hidden px-4 pb-4">
                    @forelse($workshopRegistrations as $registration)
                        @php
                            $status = strtolower($registration->status ?? 'pending');
                            $statusMap = [
                                'pending'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200',
                                'confirmed' => 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200',
                                'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200',
                            ];
                            $statusClass = $statusMap[$status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
                        @endphp

                        <article class="mb-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 p-4 shadow-sm hover:shadow-md transition">
                            <header class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                        #{{ $registration->id }} · {{ \Illuminate\Support\Str::limit($registration->name ?? '-', 60) }}
                                    </h3>
                                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-300 truncate">
                                        {{ \Illuminate\Support\Str::limit($registration->email ?? '-', 80) }}
                                    </div>
                                    <div class="text-sm text-gray-600 dark:text-gray-300">
                                        {{ $registration->phone ?? '—' }}
                                    </div>
                                    <div class="mt-2">
                                        <span class="px-2.5 py-0.5 text-[11px] font-semibold rounded-full {{ $statusClass }}">
                                            {{ ucfirst($registration->status ?? 'pending') }}
                                        </span>
                                    </div>
                                </div>
                            </header>

                            <footer class="mt-4 flex items-center gap-2">
                                <a href="{{ route('admin.workshop_registrations.edit', $registration->id) }}"
                                   class="inline-flex items-center px-3 py-2 border border-blue-300 dark:border-blue-600 
                                          text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400
                                          hover:bg-blue-600 dark:hover:bg-blue-500 hover:text-white transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.workshop_registrations.destroy', $registration->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-2 border border-red-300 dark:border-red-600 
                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400
                                                   hover:bg-red-600 dark:hover:bg-red-500 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </footer>
                        </article>
                    @empty
                        <div class="px-2 py-10 text-center text-gray-400 dark:text-gray-500">
                            <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M12 8c-1.657 0-3 .895-3 2v4h6v-4c0-1.105-1.343-2-3-2zM5 8h14M5 16h14" />
                            </svg>
                            <p class="text-lg font-medium">No workshop registrations found</p>
                            <p class="text-sm">When users register for workshops, they will appear here.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ===================== Desktop Table (sm+) ===================== --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1000px] w-full text-left border-collapse">
                            <thead>
                                <tr class="sticky top-0 z-10 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 border-b border-gray-300 dark:border-gray-700">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Name</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Email</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Phone</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Status</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($workshopRegistrations as $registration)
                                    @php
                                        $status = strtolower($registration->status ?? 'pending');
                                        $statusMap = [
                                            'pending'   => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-800 dark:text-yellow-200',
                                            'confirmed' => 'bg-green-100 text-green-700 dark:bg-green-800 dark:text-green-200',
                                            'cancelled' => 'bg-red-100 text-red-700 dark:bg-red-800 dark:text-red-200',
                                        ];
                                        $statusClass = $statusMap[$status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300';
                                    @endphp

                                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/70 hover:shadow-md transition-all duration-300 ease-in-out cursor-pointer">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">#{{ $registration->id }}</td>
                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                            {{ \Illuminate\Support\Str::limit($registration->name ?? '-', 40) }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ \Illuminate\Support\Str::limit($registration->email ?? '-', 60) }}
                                        </td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">
                                            {{ $registration->phone ?? '—' }}
                                        </td>
                                        <td class="px-6 py-4">
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full {{ $statusClass }}">
                                                {{ ucfirst($registration->status ?? 'pending') }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('admin.workshop_registrations.edit', $registration->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                                          text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400 
                                                          bg-transparent hover:bg-blue-600 dark:hover:bg-blue-500 
                                                          hover:text-white hover:border-blue-600 dark:hover:border-blue-400 transition">
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.workshop_registrations.destroy', $registration->id) }}" method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this registration?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit"
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                                   bg-transparent hover:bg-red-600 dark:hover:bg-red-500 
                                                                   hover:text-white hover:border-red-600 dark:hover:border-red-400 transition">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 dark:text-gray-500">
                                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M12 8c-1.657 0-3 .895-3 2v4h6v-4c0-1.105-1.343-2-3-2zM5 8h14M5 16h14" />
                                                </svg>
                                                <p class="text-lg font-medium">No workshop registrations found</p>
                                                <p class="text-sm">When users register for workshops, they will appear here.</p>
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
                {{ $workshopRegistrations->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
