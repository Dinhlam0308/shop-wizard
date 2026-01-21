<x-app-layout>
    <x-slot name="header">
        <div
            class="flex flex-col gap-3 max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <div class="flex items-center justify-between">
                <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                    Edit Order #{{ $order->id }}
                </h2>
                @php
                    $hasRental   = $order->items->contains(fn($i) => $i->rental_start_at && $i->rental_end_at);
                    $hasPurchase = $order->items->contains(fn($i) => !$i->rental_start_at && !$i->rental_end_at);
                    $isMixed     = $hasRental && $hasPurchase;
                @endphp
                <div class="flex items-center gap-2">
                    <span class="px-3 py-1.5 rounded-full text-xs font-semibold
                        @class([
                            'bg-yellow-100 text-yellow-800' => $order->status === 'pending',
                            'bg-blue-100 text-blue-800'     => $order->status === 'processing',
                            'bg-green-100 text-green-800'   => $order->status === 'completed',
                            'bg-red-100 text-red-800'       => $order->status === 'cancelled',
                        ])">
                        {{ \Illuminate\Support\Str::headline($order->status) }}
                    </span>
                    @if($isMixed)
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-fuchsia-100 text-fuchsia-900">Mixed</span>
                    @elseif($order->is_rental)
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-900">Rental</span>
                    @else
                        <span class="px-3 py-1.5 rounded-full text-xs font-semibold bg-gray-100 text-gray-900">Purchase</span>
                    @endif
                </div>
            </div>

            {{-- Summary mini --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 text-sm">
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2 bg-white/50 dark:bg-gray-800/50">
                    <div class="text-gray-500 dark:text-gray-400">Customer</div>
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ $order->user->name ?? 'N/A' }}</div>
                </div>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2 bg-white/50 dark:bg-gray-800/50">
                    <div class="text-gray-500 dark:text-gray-400">Payment</div>
                    <div class="font-medium text-gray-900 dark:text-gray-100">{{ strtoupper($order->payment_method ?? 'N/A') }}</div>
                </div>
                <div class="rounded-lg border border-gray-200 dark:border-gray-700 px-3 py-2 bg-white/50 dark:bg-gray-800/50">
                    <div class="text-gray-500 dark:text-gray-400">Total</div>
                    <div class="font-semibold text-gray-900 dark:text-gray-100">${{ number_format($order->total, 2) }}</div>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-12 px-6">
        {{-- Notifications --}}
        @if (session('success'))
            <x-notification type="success" :message="session('success')" />
        @endif
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <x-notification type="error" :message="$error" />
            @endforeach
        @endif

        <!-- Main Card -->
        <div
            class="rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                    bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                    transition-all duration-500 ease-in-out p-8"
            x-data="{submitting:false}">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                Edit Order Information
            </h3>

            <form action="{{ route('admin.order.update', $order->id) }}" method="POST" class="space-y-6" @submit="submitting=true">
                @csrf
                @method('PUT')

                <input type="hidden" name="id" value="{{ $order->id }}">

                {{-- Order ID --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order ID</label>
                    <input type="text" value="{{ $order->id }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-400 cursor-not-allowed">
                </div>

                {{-- Customer --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Customer</label>
                    <input type="text" value="{{ $order->user->name ?? 'Unknown User' }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                </div>

                {{-- Total --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Total Amount</label>
                    <input type="text" value="${{ number_format($order->total, 2) }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                </div>

                {{-- Payment Method --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Payment Method</label>
                    <input type="text" value="{{ ucfirst($order->payment_method ?? 'N/A') }}" readonly
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                </div>

                {{-- Status --}}
                @php $locked = in_array($order->status, ['cancelled','completed']); @endphp
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Order Status</label>
                    <select name="status" {{ $locked ? 'disabled' : '' }}
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                        <option value="pending"    {{ old('status', $order->status) == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processing" {{ old('status', $order->status) == 'processing' ? 'selected' : '' }}>Processing</option>
                        <option value="completed"  {{ old('status', $order->status) == 'completed' ? 'selected' : '' }}>Completed</option>
                        <option value="cancelled"  {{ old('status', $order->status) == 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                    </select>
                    @if($locked)
                        <p class="text-xs text-gray-500 mt-1">Đơn đã {{ $order->status }} — không thể đổi trạng thái.</p>
                    @endif
                </div>

                {{-- Created / Updated --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Created At</label>
                        <input type="text" value="{{ $order->created_at->format('d M Y, H:i') }}" readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Last Updated</label>
                        <input type="text" value="{{ $order->updated_at->format('d M Y, H:i') }}" readonly
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-100 dark:bg-gray-700 text-gray-700 dark:text-gray-300 cursor-not-allowed">
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex justify-end gap-3 pt-6">
                    <a href="{{ route('admin.order.index') }}"
                        class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                               hover:text-gray-900 dark:hover:text-white transition-colors duration-300">
                        Cancel
                    </a>

                    <button type="submit" :disabled="submitting || {{ $locked ? 'true' : 'false' }}"
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-gray-900 to-gray-800 
                               dark:from-gray-100 dark:to-gray-300 
                               text-white dark:text-gray-900 font-semibold text-sm 
                               shadow-md hover:shadow-lg hover:scale-[1.02] 
                               transition-all duration-300 ease-in-out disabled:opacity-60 disabled:cursor-not-allowed">
                        Update Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
