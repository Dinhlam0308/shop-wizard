@php
    $cards = [
        [
            'title' => 'TOTAL PRODUCTS',
            'color' => 'blue',
            'value' => $totalProducts,
            'delta' => $this->deltas['products'],
            'target' => $this->targets['products'],
        ],
        [
            'title' => 'TOTAL BOOKINGS',
            'color' => 'yellow',
            'value' => $totalBookings,
            'delta' => $this->deltas['bookings'],
            'target' => $this->targets['bookings'],
        ],
        [
            'title' => 'TOTAL NEWS',
            'color' => 'red',
            'value' => $totalNews,
            'delta' => $this->deltas['news'],
            'target' => $this->targets['news'],
        ],
        [
            'title' => 'TOTAL ORDERS',
            'color' => 'emerald',
            'value' => $totalOrders,
            'delta' => $this->deltas['orders'],
            'target' => $this->targets['orders'],
        ],
        [
            'title' => 'TOTAL REVENUE',
            'color' => 'purple',
            'value' => number_format($totalRevenue, 0, '.', ',') . 'Đ',
            'delta' => $this->deltas['revenue'],
            'target' => $this->targets['revenue'],
        ],
        [
            'title' => 'TOTAL USERS',
            'color' => 'orange',
            'value' => $totalUsers,
            'delta' => $this->deltas['users'],
            'target' => $this->targets['users'],
        ],
        [
            'title' => 'TOTAL CONTACTS',
            'color' => 'blue',
            'value' => $totalContacts,
            'delta' => $this->deltas['contacts'],
            'target' => $this->targets['contacts'],
        ],
    ];
@endphp
<div wire:poll.5s="refresh" class="space-y-6">

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6">
        @foreach ($cards as $card)
            <div
                class="rounded-2xl border border-{{ $card['color'] }}-200/50 dark:border-{{ $card['color'] }}-700/40 
                  bg-{{ $card['color'] }}-50/50 dark:bg-{{ $card['color'] }}-900/10
                  shadow-sm p-6 transition-all hover:-translate-y-0.5 hover:shadow-md">

                <div class="flex justify-between">
                    <div class="text-sm text-gray-500 dark:text-gray-400 font-medium tracking-wide uppercase">
                        {{ $card['title'] }}
                    </div>
                    <span
                        class="text-xs px-2 py-1 rounded-full bg-{{ $card['color'] }}-50 text-{{ $card['color'] }}-700 border border-{{ $card['color'] }}-100 dark:bg-{{ $card['color'] }}-900/20 dark:text-{{ $card['color'] }}-400 dark:border-{{ $card['color'] }}-700">
                        +{{ $card['delta'] }}%
                    </span>
                </div>

                <div class="mt-2 flex items-baseline gap-3">
                    <div class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        <span wire:loading.remove>{{ $card['value'] }}</span>
                        <span wire:loading
                            class="inline-block w-24 h-7 bg-gray-200 dark:bg-gray-700 rounded-md animate-pulse"></span>
                    </div>
                </div>

                <div class="mt-4">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span>Target Progress</span>
                        <span>{{ $card['target'] }}%</span>
                    </div>
                    <div class="mt-2 h-2 rounded-full bg-gray-100 dark:bg-gray-700">
                        <div class="h-2 rounded-full bg-{{ $card['color'] }}-500 transition-all duration-500 ease-out"
                            style="width: {{ $card['target'] }}%"></div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
