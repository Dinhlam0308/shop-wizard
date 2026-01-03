<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
                {{ __('Workshops') }}
            </h2>

            <a href="{{ route('admin.workshop.create') }}"
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

            <div
                class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 
                       bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl 
                       transition-all duration-500 ease-in-out">

                {{-- Search (giữ nguyên) --}}
                <div class="mx-4 my-4 flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" action="{{ route('admin.workshop.index') }}" class="flex items-center gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                               placeholder="Search by Workshop ID..."
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
                        <a href="{{ route('admin.workshop.index') }}"
                           class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                            ✕ Clear Search
                        </a>
                    @endif
                </div>

                {{-- ===================== Mobile Cards (<sm) ===================== --}}
                <div class="sm:hidden px-4 pb-4">
                    @forelse($workshops as $item)
                        @php
                            // Format an toàn
                            $dateFmt = $item->date ? optional(\Carbon\Carbon::parse($item->date))->format('M d, Y') : '-';
                            $timeFmt = $item->time ?: '-';
                            $priceFmt = is_null($item->price) ? '0.00' : number_format((float) $item->price, 2);
                        @endphp
                        <article class="mb-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80 p-4 shadow-sm hover:shadow-md transition">
                            <header class="flex items-start gap-3">
                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                        #{{ $item->id }} · {{ \Illuminate\Support\Str::limit($item->title ?? 'Untitled', 60) }}
                                    </h3>
                                    <div class="mt-1 flex flex-wrap items-center gap-x-3 gap-y-1 text-sm">
                                        <span class="inline-flex items-center text-gray-600 dark:text-gray-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3M3 11h18M5 19h14a2 2 0 0 0 2-2v-6H3v6a2 2 0 0 0 2 2z"/>
                                            </svg>
                                            {{ $dateFmt }}
                                        </span>
                                        <span class="inline-flex items-center text-gray-600 dark:text-gray-300">
                                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                            </svg>
                                            {{ $timeFmt }}
                                        </span>
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-emerald-100 text-emerald-800 dark:bg-emerald-900 dark:text-emerald-200">
                                            ${{ $priceFmt }}
                                        </span>
                                    </div>
                                    <div class="mt-1 text-sm text-gray-600 dark:text-gray-300">
                                        {{ \Illuminate\Support\Str::limit($item->location ?? '-', 70) }}
                                    </div>
                                </div>

                                <div class="shrink-0">
                                    @if ($item->image)
                                        <img src="{{ $item->image }}" alt="Workshop Image"
                                             class="w-16 h-16 object-cover rounded-lg shadow">
                                    @else
                                        <span class="text-gray-400 dark:text-gray-500 text-xs">No Image</span>
                                    @endif
                                </div>
                            </header>

                            <footer class="mt-4 flex items-center gap-2">
                                <a href="{{ route('admin.workshop.edit', $item->id) }}"
                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                          text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400 
                                          bg-transparent hover:bg-blue-600 dark:hover:bg-blue-500 
                                          hover:text-white hover:border-blue-600 dark:hover:border-blue-400
                                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                          transition-all duration-300 ease-in-out">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                    Edit
                                </a>
                                <form action="{{ route('admin.workshop.destroy', $item->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this workshop?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                   bg-transparent hover:bg-red-600 dark:hover:bg-red-500 
                                                   hover:text-white hover:border-red-600 dark:hover:border-red-400
                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 
                                                   transition-all duration-300 ease-in-out">
                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                     a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                     m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>
                                        Delete
                                    </button>
                                </form>
                            </footer>
                        </article>
                    @empty
                        <div class="px-2 py-10 text-center text-gray-400 dark:text-gray-500">
                            <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h8m-8 4h6m9 5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z" />
                            </svg>
                            <p class="text-lg font-medium">No workshops found</p>
                            <p class="text-sm">Start by creating your first workshop.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ===================== Desktop Table (sm+) ===================== --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1100px] w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="sticky top-0 z-10 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 border-b border-gray-300 dark:border-gray-700">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">ID</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Title</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Date</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Time</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Price</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Location</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Image</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($workshops as $item)
                                    @php
                                        $dateFmt = $item->date ? optional(\Carbon\Carbon::parse($item->date))->format('M d, Y') : '-';
                                        $timeFmt = $item->time ?: '-';
                                        $priceFmt = is_null($item->price) ? '0.00' : number_format((float) $item->price, 2);
                                    @endphp
                                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/70 transition-all duration-300 ease-in-out cursor-pointer">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100">#{{ $item->id }}</td>

                                        <td class="px-6 py-4 font-semibold text-gray-900 dark:text-gray-100">
                                            {{ \Illuminate\Support\Str::limit($item->title ?? 'Untitled', 60) }}
                                        </td>

                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $dateFmt }}</td>
                                        <td class="px-6 py-4 text-gray-600 dark:text-gray-300">{{ $timeFmt }}</td>

                                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200">${{ $priceFmt }}</td>

                                        <td class="px-6 py-4 text-gray-700 dark:text-gray-300">
                                            {{ \Illuminate\Support\Str::limit($item->location ?? '-', 40) }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($item->image)
                                                <img src="{{ $item->image }}" alt="Workshop Image"
                                                     class="w-16 h-16 object-cover rounded-lg shadow">
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">No Image</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-3">
                                                <a href="{{ route('admin.workshop.edit', $item->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                                          text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400 
                                                          bg-transparent hover:bg-blue-600 dark:hover:bg-blue-500 
                                                          hover:text-white hover:border-blue-600 dark:hover:border-blue-400
                                                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 
                                                          transition-all duration-300 ease-in-out">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414 a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.workshop.destroy', $item->id) }}" method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Are you sure you want to delete this workshop?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                                   bg-transparent hover:bg-red-600 dark:hover:bg-red-500 
                                                                   hover:text-white hover:border-red-600 dark:hover:border-red-400
                                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 
                                                                   transition-all duration-300 ease-in-out">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
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
                                        <td colspan="8" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 dark:text-gray-500">
                                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5
                                                         a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586
                                                         a1 1 0 00-.707.293l-2.414 2.414
                                                         a1 1 0 01-.707.293h-3.172
                                                         a1 1 0 01-.707-.293l-2.414-2.414
                                                         A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-medium">No workshops found</p>
                                                <p class="text-sm">Start by creating your first workshop.</p>
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
                {{ $workshops->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
