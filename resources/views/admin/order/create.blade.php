<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Create New Order
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

        <div class="rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                    bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                    transition-all duration-500 ease-in-out p-8"
            x-data="orderForm()">

            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                Order Information
            </h3>

            <form action="{{ route('admin.order.store') }}" method="POST" class="space-y-8">
                @csrf

                {{-- Hidden: is_rental của ORDER (tự động nếu có ít nhất 1 item rental) --}}
                <input type="hidden" name="is_rental" :value="anyRental ? 1 : 0">

                {{-- Select User --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Customer (User)
                    </label>
                    <select name="user_id" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                        <option value="">-- Select User --</option>
                        @foreach (\App\Models\User::all() as $user)
                            <option value="{{ $user->id }}" {{ old('user_id') == $user->id ? 'selected' : '' }}>
                                {{ $user->name }} ({{ $user->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Payment Method --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Payment Method
                    </label>
                    <select name="payment_method" required
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                        <option value="">-- Select Payment Method --</option>
                        <option value="cod">cod</option>
                        <option value="banking">banking</option>
                        <option value="vnpay">vnpay</option>
                        <option value="momo">momo</option>
                    </select>
                </div>

                {{-- Order Items --}}
                <div class="space-y-4">
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Order Items
                    </label>

                    <template x-for="(item, index) in items" :key="index">
                        <div
                            class="grid grid-cols-1 md:grid-cols-3 gap-4 bg-gray-50/70 dark:bg-gray-700/70 p-4 rounded-xl">

                            {{-- Product --}}
                            <div>
                                <select :name="`items[${index}][product_id]`" x-model="item.product_id"
                                    @change="onProductChange(index, $event)"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                     bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500">
                                    <option value="">Select Product</option>
                                    @foreach (\App\Models\Product::all() as $product)
                                        <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                            data-is-rental="{{ (int) $product->is_rental }}">
                                            {{ $product->name }} - ${{ $product->price }}
                                            {{ $product->is_rental ? '(rental)' : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            {{-- Quantity --}}
                            <div>
                                <input type="number" min="1" :name="`items[${index}][quantity]`"
                                    x-model.number="item.quantity" @input="calculateTotal()"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                    bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500"
                                    placeholder="Quantity">
                            </div>

                            {{-- Unit price (readonly) --}}
                            <div>
                                <input type="number" min="0" step="0.01" readonly
                                    :name="`items[${index}][price]`" x-model="item.price"
                                    class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                    bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100 focus:ring-blue-500">
                                <p class="mt-1 text-xs text-gray-500" x-cloak x-show="item.is_rental">
                                    Unit price per night after 200% increase.
                                </p>
                            </div>

                            {{-- Rental dates --}}
                            <template x-if="item.is_rental">
                                <div class="md:col-span-3 grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div class="md:col-span-1">
                                        <label
                                            class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Rental
                                            Start</label>
                                        <input type="date" :name="`items[${index}][rental_start_at]`"
                                            x-model="item.rental_start_at"
                                            @change="if(item.rental_end_at && item.rental_end_at < item.rental_start_at){ item.rental_end_at = item.rental_start_at } ; calculateTotal()"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                    bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-1">
                                        <label
                                            class="block text-xs font-medium text-gray-600 dark:text-gray-300 mb-1">Rental
                                            End</label>
                                        <input type="date" :min="item.rental_start_at || null"
                                            :name="`items[${index}][rental_end_at]`" x-model="item.rental_end_at"
                                            @change="calculateTotal()"
                                            class="w-full px-3 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                    bg-white dark:bg-gray-800 text-gray-900 dark:text-gray-100 focus:ring-blue-500">
                                    </div>
                                    <div class="md:col-span-1 flex items-end">
                                        <div class="text-xs text-gray-500 dark:text-gray-400 space-y-1">
                                            <div>
                                                <span>Days: </span>
                                                <span class="font-medium" x-text="rentalDays(item) || '-'"></span>
                                            </div>
                                            <div x-cloak x-show="rentalDays(item) >= 3"
                                                class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full bg-emerald-100 text-emerald-700">
                                                <span>-30% for long-term</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </template>

                            {{-- Remove --}}
                            <div class="md:col-span-3 flex items-center justify-between mt-2">
                                <div class="text-sm text-gray-600 dark:text-gray-300">
                                    <span class="font-medium">Total: </span>
                                    <span x-text="formatMoney(lineTotal(item))"></span>
                                </div>
                                <button type="button" @click="removeItem(index)"
                                    class="text-red-500 hover:text-red-700 dark:hover:text-red-400 text-sm transition">
                                    ✕ Remove Item
                                </button>
                            </div>
                        </div>
                    </template>

                    <button type="button" @click="addItem()"
                        class="mt-2 px-4 py-2 rounded-lg border border-gray-300 dark:border-gray-600 
                               text-sm text-gray-700 dark:text-gray-200 bg-gray-100 dark:bg-gray-700 
                               hover:bg-gray-200 dark:hover:bg-gray-600 transition">
                        + Add Item
                    </button>
                </div>

                {{-- Total (auto-calculated) --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Total Amount (vnd)
                    </label>
                    <input type="number" name="total" readonly x-model="total.toFixed(2)"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                               bg-gray-100 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                               focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                </div>

                {{-- Actions --}}
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.order.index') }}"
                        class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                               hover:text-gray-900 dark:hover:text-white transition duration-300">
                        Cancel
                    </a>

                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-gray-900 to-gray-800 
                               dark:from-gray-100 dark:to-gray-300 
                               text-white dark:text-gray-900 font-semibold text-sm 
                               shadow-md hover:shadow-lg hover:scale-[1.02] 
                               transition-all duration-300 ease-in-out">
                        Save Order
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>

<script>
    function orderForm() {
        return {
            items: [{
                product_id: '',
                quantity: 1,
                base_price: 0,
                price: 0,
                is_rental: false,
                rental_start_at: null,
                rental_end_at: null
            }],
            total: 0,

            get anyRental() {
                return this.items.some(i => i.is_rental);
            },

            onProductChange(index, event) {
                const opt = event.target.options[event.target.selectedIndex];
                const basePrice = parseFloat(opt.dataset.price || 0);
                const isRental = !!parseInt(opt.dataset.isRental || 0);

                const item = this.items[index];
                item.base_price = basePrice;
                item.is_rental = isRental;

                // Đơn giá gửi lên server:
                // - Mua thường: base
                // - Thuê: base * 2 (đơn giá/đêm)
                item.price = this.unitPrice(item);

                // Nếu không thuê thì xoá ngày
                if (!isRental) {
                    item.rental_start_at = null;
                    item.rental_end_at = null;
                }

                this.calculateTotal();
            },

            unitPrice(item) {
                return Number((item.is_rental ? item.base_price * 2 : item.base_price).toFixed(2));
            },

            rentalDays(item) {
                if (!item.is_rental || !item.rental_start_at || !item.rental_end_at) return 0;
                // item.rental_* là chuỗi 'YYYY-MM-DD'
                const [ys, ms, ds] = item.rental_start_at.split('-').map(Number);
                const [ye, me, de] = item.rental_end_at.split('-').map(Number);
                const start = new Date(ys, ms - 1, ds);
                const end = new Date(ye, me - 1, de);
                const msDiff = end - start;
                if (isNaN(msDiff) || msDiff < 0) return 0;

                // TÍNH THEO NGÀY DƯƠNG LỊCH, CÓ TÍNH CẢ HAI ĐẦU (inclusive)
                const days = Math.floor(msDiff / (1000 * 60 * 60 * 24)) + 1;
                return Math.max(1, days);
            },

            lineTotal(item) {
                const qty = Number(item.quantity || 0);
                const unit = this.unitPrice(item);
                if (!item.is_rental) {
                    return qty * unit;
                }
                const days = this.rentalDays(item);
                let total = qty * unit * (days || 1);
                if (days >= 3) {
                    total *= 0.7; // giảm 30% cho thuê >= 3 ngày
                }
                return Number(total.toFixed(2));
            },

            calculateTotal() {
                // Cập nhật lại đơn giá dựa trên base_price/is_rental (để input price gửi đúng)
                this.items = this.items.map(it => ({
                    ...it,
                    price: this.unitPrice(it)
                }));
                this.total = this.items.reduce((sum, it) => sum + this.lineTotal(it), 0);
            },

            addItem() {
                this.items.push({
                    product_id: '',
                    quantity: 1,
                    base_price: 0,
                    price: 0,
                    is_rental: false,
                    rental_start_at: null,
                    rental_end_at: null
                });
            },

            removeItem(index) {
                this.items.splice(index, 1);
                this.calculateTotal();
            },

            formatMoney(v) {
                return Number(v || 0).toFixed(2) + 'vnd';
            }
        };
    }
</script>
