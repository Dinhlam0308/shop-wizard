<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
                {{ __('Order') }}
            </h2>
            <a href="{{ route('admin.order.create') }}"
                class="inline-flex items-center px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 
                      text-sm font-semibold 
                      text-gray-700 dark:text-gray-200 rounded-xl
                      bg-transparent hover:bg-gray-800 dark:hover:bg-gray-700 
                      hover:text-white hover:border-gray-800 dark:hover:border-gray-500
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300 ease-in-out">
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
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    <x-notification type="error" :message="$error" />
                @endforeach
            @endif

            <div
                class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 
                       bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl 
                       transition-all duration-500 ease-in-out">

                {{-- ===================== Search Form (GIỮ NGUYÊN) ===================== --}}
                <div class="mx-4 my-4 flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" action="{{ route('admin.order.index') }}" class="flex items-center gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by Order ID..."
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

                    {{-- Reset button --}}
                    @if (request('search'))
                        <a href="{{ route('admin.order.index') }}"
                            class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                            ✕ Clear Search
                        </a>
                    @endif
                </div>

                {{-- ===================== Mobile Cards (<sm) ===================== --}}
                <div class="sm:hidden px-4 pb-4">
                    @forelse($orders as $order)
                        <article
                            class="mb-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80
                                   p-4 shadow-sm hover:shadow-md transition">
                            <header class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                        #{{ $order->id }} · {{ \Illuminate\Support\Str::limit($order->user->name ?? 'Unknown', 40) }}
                                    </h3>
                                    <p class="text-sm text-gray-500 dark:text-gray-400 truncate">
                                        {{ $order->user->email ?? '-' }}
                                    </p>
                                </div>
                                <div class="shrink-0 text-right">
                                    @php
                                        $statusColors = [
                                            'pending'   => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                            'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                        ];
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </header>

                            <div class="mt-3 grid grid-cols-2 gap-2 text-sm">
                                <div class="text-gray-700 dark:text-gray-300">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Total</span>
                                    <div class="font-semibold">${{ number_format($order->total, 2) }}</div>
                                </div>
                                <div class="text-gray-700 dark:text-gray-300">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Payment</span>
                                    <div>{{ $order->payment_method ?? 'N/A' }}</div>
                                </div>
                                <div class="text-gray-700 dark:text-gray-300">
                                    <span class="text-xs text-gray-500 dark:text-gray-400">Rental</span>
                                    @if ($order->is_rental)
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">Yes</span>
                                    @else
                                        <span class="inline-flex items-center px-2 py-0.5 rounded-full text-[11px] font-medium bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">No</span>
                                    @endif
                                </div>
                            </div>

                            <footer class="mt-4 flex items-center gap-2">
                                <a href="{{ route('admin.order.show', $order->id) }}"
                                   class="inline-flex items-center justify-center rounded-lg border border-gray-300 dark:border-gray-600
                                          px-3 py-2 text-xs font-medium text-gray-700 dark:text-gray-300
                                          hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                    View
                                </a>
                                <a href="{{ route('admin.order.edit', $order->id) }}"
                                   class="inline-flex items-center justify-center rounded-lg border border-blue-300 dark:border-blue-600
                                          px-3 py-2 text-xs font-medium text-blue-600 dark:text-blue-400
                                          hover:bg-blue-600 dark:hover:bg-blue-500 hover:text-white transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this order?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-lg border border-red-300 dark:border-red-600
                                                   px-3 py-2 text-xs font-medium text-red-600 dark:text-red-400
                                                   hover:bg-red-600 dark:hover:bg-red-500 hover:text-white transition">
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
                            <p class="text-lg font-medium">No orders found</p>
                            <p class="text-sm">Orders will appear here once customers make purchases.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ===================== Desktop Table (sm+) ===================== --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1024px] w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="sticky top-0 z-10 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 
                                           border-b border-gray-300 dark:border-gray-700">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-20">ID</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Customer</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-32">Total</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-40">Payment</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-32">Status</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-28">Rental</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[20%]">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($orders as $order)
                                    <tr
                                        class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/70 
                                               hover:shadow-md transition-all duration-300 ease-in-out cursor-pointer">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                            #{{ $order->id }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100">
                                                {{ $order->user->name ?? 'Unknown' }}
                                            </div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400 truncate max-w-[320px]">
                                                {{ $order->user->email ?? '-' }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                            <span class="font-bold">${{ number_format($order->total, 2) }}</span>
                                        </td>

                                        <td class="px-6 py-4 text-gray-800 dark:text-gray-200">
                                            {{ $order->payment_method ?? 'N/A' }}
                                        </td>

                                        <td class="px-6 py-4">
                                            @php
                                                $statusColors = [
                                                    'pending'   => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-200',
                                                    'completed' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                                    'cancelled' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200',
                                                ];
                                            @endphp
                                            <span
                                                class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                       {{ $statusColors[$order->status] ?? 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300' }}">
                                                {{ ucfirst($order->status) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($order->is_rental)
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                           bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200">
                                                    Yes
                                                </span>
                                            @else
                                                <span
                                                    class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                                                           bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300">
                                                    No
                                                </span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                {{-- View --}}
                                                <a href="{{ route('admin.order.show', $order->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600 
                                                          text-xs font-medium rounded-lg text-gray-700 dark:text-gray-300
                                                          hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    View
                                                </a>

                                                {{-- Edit --}}
                                                <a href="{{ route('admin.order.edit', $order->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                                          text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400 
                                                          hover:bg-blue-600 dark:hover:bg-blue-500 
                                                          hover:text-white transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414
                                                                 a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                {{-- Delete --}}
                                                <form action="{{ route('admin.order.destroy', $order->id) }}" method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Are you sure you want to delete this order?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                                   hover:bg-red-600 dark:hover:bg-red-500 
                                                                   hover:text-white transition">
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
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5
                                                         a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586
                                                         a1 1 0 00-.707.293l-2.414 2.414
                                                         a1 1 0 01-.707.293h-3.172
                                                         a1 1 0 01-.707-.293l-2.414-2.414
                                                         A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-medium">No orders found</p>
                                                <p class="text-sm">Orders will appear here once customers make purchases.</p>
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
                {{ $orders->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
