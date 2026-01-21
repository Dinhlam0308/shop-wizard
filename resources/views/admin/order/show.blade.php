<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 
                    bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                Order #{{ $order->id }}
            </h2>

            @php
                $hasRental = $order->items->contains(fn($i) => $i->rental_start_at && $i->rental_end_at);
                $hasPurchase = $order->items->contains(fn($i) => !$i->rental_start_at && !$i->rental_end_at);
                $isMixed = $hasRental && $hasPurchase;
            @endphp

            <div class="flex items-center gap-2">
                <span
                    class="px-3 py-1.5 rounded-full text-xs font-semibold
                    @class([
                        'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                        'bg-blue-100 text-blue-800' => $order->status === 'processing',
                        'bg-green-100 text-green-800' => $order->status === 'completed',
                        'bg-red-100 text-red-800' => $order->status === 'cancelled',
                    ])">
                    {{ Str::headline($order->status) }}
                </span>

                @if ($isMixed)
                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-fuchsia-100 text-fuchsia-900">
                        Mixed (Buy + Rental)
                    </span>
                @elseif($order->is_rental)
                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-900">
                        Rental
                    </span>
                @else
                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-900">
                        Purchase
                    </span>
                @endif
            </div>
        </div>
    </x-slot>

    <div class="max-w-7xl mx-auto py-10 px-6 space-y-6">
        {{-- Notifications --}}
        @if (session('success'))
            <x-notification type="success" :message="session('success')" />
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <x-notification type="error" :message="$error" />
            @endforeach
        @endif

        {{-- SUMMARY --}}
        <div
            class="rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 
                    bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-6">
            <div class="grid md:grid-cols-4 gap-6">
                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Customer</div>
                    <div class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                        {{ $order->user->name ?? 'N/A' }}
                    </div>
                    <div class="text-xs text-gray-500">{{ $order->user->email ?? '' }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Payment Method</div>
                    <div class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                        {{ strtoupper($order->payment_method) }}
                    </div>
                </div>

                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Created At</div>
                    <div class="mt-1 font-medium text-gray-900 dark:text-gray-100">
                        {{ $order->created_at->format('d/m/Y H:i') }}
                    </div>
                </div>

                <div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">Total</div>
                    <div class="mt-1 text-2xl font-semibold text-gray-900 dark:text-gray-100">
                        {{ number_format($order->total, 2) }}
                    </div>
                </div>
            </div>

            {{-- SHIPPING INFO --}}
            <div
                class="relative mt-8 rounded-2xl overflow-hidden
            border border-gray-200/70 dark:border-gray-700/60
            bg-white/60 dark:bg-gray-800/60 backdrop-blur-xl
            shadow-[0_20px_60px_-30px_rgba(0,0,0,0.35)]
            transition hover:-translate-y-[1px] hover:shadow-[0_25px_70px_-35px_rgba(0,0,0,0.45)]">

                {{-- Accent top border --}}
                <div class="absolute inset-x-0 top-0 h-1 bg-gradient-to-r from-indigo-500 via-fuchsia-500 to-amber-400">
                </div>

                {{-- Decorative blobs --}}
                <div
                    class="pointer-events-none absolute -top-14 -right-14 w-44 h-44 bg-indigo-500/15 rounded-full blur-3xl">
                </div>
                <div
                    class="pointer-events-none absolute -bottom-16 -left-16 w-44 h-44 bg-fuchsia-500/15 rounded-full blur-3xl">
                </div>

                <div class="relative p-6">
                    {{-- Header --}}
                    <div class="flex items-center justify-between gap-4 mb-6">
                        <div class="flex items-center gap-3">
                            <div
                                class="flex items-center justify-center w-11 h-11 rounded-2xl
                            bg-gradient-to-br from-indigo-500/15 to-fuchsia-500/15
                            text-indigo-700 dark:text-indigo-300
                            border border-white/30 dark:border-white/10">
                                <i data-lucide="map-pin" class="w-5 h-5"></i>
                            </div>

                            <div>
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 leading-tight">
                                    Shipping Information
                                </h3>
                                <p class="text-xs text-gray-500 dark:text-gray-400">
                                    Receiver details & delivery address
                                </p>
                            </div>
                        </div>

                        {{-- Actions (optional but fancy) --}}
                        <div class="flex items-center gap-2">
                            {{-- Call --}}
                            @if (!empty($order->receiver_phone))
                                <a href="tel:{{ $order->receiver_phone }}"
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold
                                bg-gray-900/5 dark:bg-white/5
                                hover:bg-gray-900/10 dark:hover:bg-white/10
                                border border-gray-200/60 dark:border-gray-700/60
                                text-gray-800 dark:text-gray-100 transition">
                                    <i data-lucide="phone" class="w-4 h-4"></i>
                                    Call
                                </a>
                            @endif

                            {{-- Open map --}}
                            @if (!empty($order->shipping_address))
                                <a target="_blank"
                                    href="https://www.google.com/maps/search/?api=1&query={{ urlencode($order->shipping_address) }}"
                                    class="inline-flex items-center gap-2 px-3 py-2 rounded-xl text-xs font-semibold
                                bg-indigo-600/10 text-indigo-700
                                dark:bg-indigo-400/10 dark:text-indigo-300
                                hover:bg-indigo-600/15 dark:hover:bg-indigo-400/15
                                border border-indigo-500/20 transition">
                                    <i data-lucide="map" class="w-4 h-4"></i>
                                    Map
                                </a>
                            @endif
                        </div>
                    </div>

                    {{-- Content cards --}}
                    <div class="grid md:grid-cols-3 gap-4">
                        {{-- Receiver Name --}}
                        <div
                            class="relative p-4 rounded-2xl
                            bg-white/70 dark:bg-gray-900/30
                            border border-gray-200/60 dark:border-gray-700/60">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-indigo-700 dark:text-indigo-300">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                        Receiver Name
                                    </div>
                                    <div class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $order->receiver_name ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Receiver Phone --}}
                        <div
                            class="relative p-4 rounded-2xl
                            bg-white/70 dark:bg-gray-900/30
                            border border-gray-200/60 dark:border-gray-700/60">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-fuchsia-700 dark:text-fuchsia-300">
                                    <i data-lucide="phone" class="w-4 h-4"></i>
                                </div>
                                <div>
                                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                        Receiver Phone
                                    </div>
                                    <div class="mt-1 font-semibold text-gray-900 dark:text-gray-100">
                                        {{ $order->receiver_phone ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Shipping Address --}}
                        <div
                            class="md:col-span-3 relative p-4 rounded-2xl
                            bg-white/70 dark:bg-gray-900/30
                            border border-gray-200/60 dark:border-gray-700/60">
                            <div class="flex items-start gap-3">
                                <div class="mt-0.5 text-amber-700 dark:text-amber-300">
                                    <i data-lucide="home" class="w-4 h-4"></i>
                                </div>
                                <div class="min-w-0">
                                    <div class="text-xs uppercase tracking-wide text-gray-500 dark:text-gray-400">
                                        Shipping Address
                                    </div>
                                    <div
                                        class="mt-1 font-medium text-gray-900 dark:text-gray-100 break-words leading-relaxed">
                                        {{ $order->shipping_address ?? 'N/A' }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>



        {{-- ITEMS --}}
        <div
            class="rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 
                    bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-6 overflow-x-auto">
            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">Order Items</h3>

            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50/60 dark:bg-gray-700/60">
                    <tr>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">#
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Product</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Variant
                        </th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Qty</th>
                        <th class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Unit Price</th>
                        @if ($hasRental)
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                Rental Start</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                Rental End</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                Days</th>
                            <th
                                class="px-4 py-3 text-left text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                                Discount</th>
                        @endif
                        <th class="px-4 py-3 text-right text-xs font-medium text-gray-600 dark:text-gray-300 uppercase">
                            Line Total</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach ($order->items as $i => $item)
                        @php
                            $start = $item->rental_start_at ? \Carbon\Carbon::parse($item->rental_start_at) : null;
                            $end = $item->rental_end_at ? \Carbon\Carbon::parse($item->rental_end_at) : null;
                            $days = $start && $end ? max(1, $start->diffInDays($end) + 1) : 1;
                            $isRental = $item->rental_start_at && $item->rental_end_at;

                            $discount = $isRental && $days >= 3 ? 0.3 : 0;
                            $subtotal = $isRental
                                ? $item->price * $item->quantity * $days * (1 - $discount)
                                : $item->price * $item->quantity;
                        @endphp

                        <tr class="hover:bg-gray-50/50 dark:hover:bg-gray-700/40 transition">
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $i + 1 }}</td>

                            <td class="px-4 py-3">
                                <div class="text-sm font-medium text-gray-900 dark:text-gray-100">
                                    {{ $item->product->name ?? 'Product #' . $item->product_id }}
                                </div>
                                @if ($isRental)
                                    <span
                                        class="text-[11px] px-2 py-0.5 rounded-full bg-amber-100 text-amber-900">Rental</span>
                                @else
                                    <span
                                        class="text-[11px] px-2 py-0.5 rounded-full bg-gray-100 text-gray-900">Purchase</span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                @if ($item->variant_id)
                                    <div class="flex flex-wrap gap-2 items-center">
                                        <span
                                            class="text-[11px] px-2 py-0.5 rounded-full bg-indigo-100 text-indigo-800">
                                            Variant #{{ $item->variant_id }}
                                        </span>

                                        @if (!empty($item->variant?->color))
                                            <span
                                                class="text-[11px] px-2 py-0.5 rounded-full bg-stone-100 text-stone-800">
                                                Color: <span class="font-semibold">{{ $item->variant->color }}</span>
                                            </span>
                                        @endif

                                        @if (!empty($item->variant?->size))
                                            <span
                                                class="text-[11px] px-2 py-0.5 rounded-full bg-stone-100 text-stone-800">
                                                Size: <span class="font-semibold">{{ $item->variant->size }}</span>
                                            </span>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-xs text-gray-500 italic">—</span>
                                @endif
                            </td>

                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">{{ $item->quantity }}</td>
                            <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                {{ number_format($item->price, 2) }}</td>

                            @if ($hasRental)
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $start ? $start->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $end ? $end->format('d/m/Y') : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $isRental ? $days : '-' }}
                                </td>
                                <td class="px-4 py-3 text-sm text-gray-700 dark:text-gray-200">
                                    {{ $discount > 0 ? '-30%' : '-' }}
                                </td>
                            @endif

                            <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                                {{ number_format($subtotal, 2) }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>

                <tfoot class="bg-gray-50/60 dark:bg-gray-700/60">
                    @php
                        $calculatedTotal = $order->items->sum(function ($i) {
                            $start = $i->rental_start_at ? \Carbon\Carbon::parse($i->rental_start_at) : null;
                            $end = $i->rental_end_at ? \Carbon\Carbon::parse($i->rental_end_at) : null;
                            $days = $start && $end ? max(1, $start->diffInDays($end) + 1) : 1;
                            $isRental = $i->rental_start_at && $i->rental_end_at;
                            $discount = $isRental && $days >= 3 ? 0.3 : 0;

                            return $isRental
                                ? $i->price * $i->quantity * $days * (1 - $discount)
                                : $i->price * $i->quantity;
                        });
                    @endphp

                    <tr>
                        <td colspan="{{ 5 + ($hasRental ? 4 : 0) }}"
                            class="px-4 py-3 text-right text-sm font-medium text-gray-700 dark:text-gray-200">
                            Subtotal
                        </td>
                        <td class="px-4 py-3 text-right text-sm font-semibold text-gray-900 dark:text-gray-100">
                            {{ number_format($calculatedTotal, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="{{ 5 + ($hasRental ? 4 : 0) }}"
                            class="px-4 py-3 text-right text-sm font-medium text-gray-700 dark:text-gray-200">
                            Total
                        </td>
                        <td class="px-4 py-3 text-right text-lg font-bold text-gray-900 dark:text-gray-100">
                            {{ number_format($order->total, 2) }}
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>

        {{-- ACTIONS (tuỳ chọn) --}}
        <div
            class="rounded-2xl shadow-xl border border-gray-200 dark:border-gray-700 
                    bg-white/80 dark:bg-gray-800/80 backdrop-blur-md p-6 flex flex-wrap gap-3 justify-end">
            <a href="{{ route('admin.order.index') }}"
                class="px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 transition">
                Back to Orders
            </a>
        </div>
    </div>

    @push('scripts')
        <script src="https://unpkg.com/lucide@latest" defer></script>
        <script>
            document.addEventListener('DOMContentLoaded', () => window.lucide && lucide.createIcons());
        </script>
    @endpush
</x-app-layout>
