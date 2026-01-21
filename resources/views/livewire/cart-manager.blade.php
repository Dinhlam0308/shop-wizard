<div>
    <div class="max-w-4xl mx-auto mt-12 space-y-6 py-12 px-4 sm:px-6 lg:px-8" x-data="cartOrderForm(@js($items ?? []), {
        stateUrl: @js(route('user.cart.state')),
        updateUrlBase: @js(route('user.cart.items.update', ['cartItem' => '___ID___'])),
        removeUrlBase: @js(route('user.cart.items.remove', ['cartItem' => '___ID___'])),
        clearUrl: @js(route('user.cart.clear')),
    })"
        x-init="init()">

        {{-- Header --}}
        <div class="text-center mb-8">
            <h2 class="hp-title text-amber-200 text-2xl sm:text-3xl mb-2">
                <span data-vi="Giỏ Hàng Của Bạn" data-en="Your Shopping Cart"></span>
            </h2>
            <p class="text-stone-400/80 text-sm">
                <span data-vi="Trải nghiệm magical trong giỏ hàng" data-en="Magic Glass Experience"></span>
            </p>
        </div>

        {{-- Empty --}}
        <template x-if="items.length === 0">
            <div class="text-center text-stone-400/80 py-12">
                <p>
                    <span data-vi="Giỏ hàng của bạn đang trống." data-en="Your cart is empty."></span>
                </p>
            </div>
        </template>

        {{-- Items --}}
        <template x-for="(it, i) in items" :key="it.cart_item_id">
            <div
                class="hp-card p-4 sm:p-5 rounded-2xl backdrop-blur-lg bg-stone-900/60 border border-amber-400/20
                       flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 sm:gap-6
                       group transition-all duration-500 hover:scale-[1.02]">
                <div class="flex-1">
                    <p class="text-amber-100 font-medium text-base sm:text-lg" x-text="it.name"></p>

                    <!-- Variant info -->
                    <template x-if="it.variant_id">
                        <div class="mt-1 flex flex-wrap items-center gap-2 text-xs">
                            <!-- Color pill -->
                            <template x-if="it.variant_color">
                                <span
                                    class="inline-flex items-center gap-2 px-2.5 py-1 rounded-full
                   bg-stone-800/60 border border-stone-700/60 text-stone-200">
                                    Color:
                                    <span class="font-medium" x-text="it.variant_color"></span>
                                </span>
                            </template>

                            <!-- Size pill -->
                            <template x-if="it.variant_size">
                                <span
                                    class="inline-flex items-center px-2.5 py-1 rounded-full
                   bg-stone-800/60 border border-stone-700/60 text-stone-200">
                                    Size: <span class="ml-1 font-medium" x-text="it.variant_size"></span>
                                </span>
                            </template>
                        </div>
                    </template>

                    <template x-if="it.is_rental">
                        <div>
                            <div class="mt-2 grid grid-cols-2 gap-2 max-w-md">
                                <div>
                                    <label class="block text-[11px] text-stone-400 mb-1">
                                        <span data-vi="Ngày bắt đầu" data-en="Start Date"></span>
                                    </label>
                                    <input type="date"
                                        class="w-full px-3 py-2 rounded-lg border border-stone-700/60 bg-stone-900/60 text-amber-100
                                               focus:outline-none focus:ring-2 focus:ring-amber-500"
                                        x-model="it.rental_start_at" @change="updateDates(it)">
                                </div>

                                <div>
                                    <label class="block text-[11px] text-stone-400 mb-1">
                                        <span data-vi="Ngày kết thúc" data-en="End Date"></span>
                                    </label>
                                    <input type="date"
                                        class="w-full px-3 py-2 rounded-lg border border-stone-700/60 bg-stone-900/60 text-amber-100
                                               focus:outline-none focus:ring-2 focus:ring-amber-500"
                                        x-model="it.rental_end_at" @change="updateDates(it)">
                                </div>
                            </div>

                            <p class="text-stone-400/70 text-xs mt-2">
                                <template x-if="rentalDays(it) > 0">
                                    <span>
                                        <span data-vi="Ngày thuê:" data-en="Rental period:"></span>
                                        <span class="text-amber-300/90"
                                            x-text="`${formatDate(it.rental_start_at)} – ${formatDate(it.rental_end_at)}`"></span>
                                        <span class="text-amber-300/80" x-text="`(${rentalDays(it)} ngày)`"></span>

                                        <template x-if="rentalDays(it) >= 3">
                                            <span class="ml-1 text-emerald-400/80 italic"><span data-vi="- Giảm 30%"
                                                    data-en="- 30% off"></span></span>
                                        </template>
                                    </span>
                                </template>

                                <template x-if="rentalDays(it) === 0">
                                    <span class="italic text-red-300"><span data-vi="chưa chọn ngày"
                                            data-en="no date selected"></span></span>
                                </template>
                            </p>
                        </div>
                    </template>

                    <p class="text-stone-400/70 text-sm sm:text-base mt-1">
                        <span x-text="formatMoney(unitPrice(it))"></span>
                        <template x-if="it.is_rental">
                            <span class="text-amber-400/80 text-xs italic"><span data-vi="(giá/đêm)"
                                    data-en="(price/night)"></span></span>
                        </template>
                    </p>
                </div>

                {{-- Actions + line total --}}
                <div class="flex items-center justify-between sm:justify-end flex-wrap gap-3 sm:gap-4 w-full sm:w-auto">
                    <button type="button" @click="dec(it)"
                        class="w-7 h-7 rounded-full bg-amber-500/20 text-amber-300 flex items-center justify-center hover:bg-amber-400/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M5 12h14" />
                        </svg>
                    </button>

                    <span class="w-6 text-center text-amber-100" x-text="it.quantity"></span>

                    <button type="button" @click="inc(it)"
                        class="w-7 h-7 rounded-full bg-amber-500/20 text-amber-300 flex items-center justify-center hover:bg-amber-400/30 transition">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M12 5v14" />
                            <path d="M5 12h14" />
                        </svg>
                    </button>

                    <span class="text-amber-300 font-semibold text-sm sm:text-base w-28 text-right"
                        x-text="formatMoney(lineTotal(it))"></span>

                    <button type="button" @click="askRemove(it)"
                        class="text-red-400/70 hover:text-red-300 transition ml-2 text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                            stroke="currentColor" stroke-width="2">
                            <path d="M3 6h18" />
                            <path d="M8 6V4h8v2" />
                            <path d="M19 6l-1 14H6L5 6" />
                            <path d="M10 11v6" />
                            <path d="M14 11v6" />
                        </svg>
                    </button>
                </div>
            </div>
        </template>

        {{-- Footer --}}
        <template x-if="items.length">
            <div
                class="flex flex-col sm:flex-row items-center sm:justify-between pt-6 border-t border-stone-700/40 gap-4">
                <div class="order-2 sm:order-1">
                    <button type="button" @click="askClearAll()"
                        class="text-stone-400/70 text-sm hover:text-red-400 transition">
                        <span data-vi="Xóa tất cả" data-en="Clear All"></span>
                    </button>
                </div>

                <div class="text-right order-1 sm:order-2 w-full sm:w-auto">
                    <p class="text-stone-400/70 text-sm"><span data-vi="Tổng cộng" data-en="Total"></span></p>
                    <p class="text-amber-200 text-2xl font-bold truncate" x-text="formatMoney(total)"></p>

                    <form method="POST" id="orderForm" action="{{ route('user.order.store') }}">
                        @csrf
                        <input type="hidden" name="user_id" value="{{ auth()->id() }}">
                        <input type="hidden" name="payment_method" value="cod">

                        <input type="hidden" name="total" :value="total">
                        <input type="hidden" name="is_rental" :value="anyRental ? 1 : 0">

                        <template x-for="(it, idx) in items" :key="it.cart_item_id">
                            <div>
                                <input type="hidden" :name="`items[${idx}][variant_id]`" :value="it.variant_id">
                                <input type="hidden" :name="`items[${idx}][product_id]`" :value="it.product_id">
                                <input type="hidden" :name="`items[${idx}][quantity]`" :value="it.quantity">
                                <input type="hidden" :name="`items[${idx}][price]`" :value="unitPrice(it)">

                                <template x-if="it.is_rental">
                                    <div>
                                        <input type="hidden" :name="`items[${idx}][rental_start_at]`"
                                            :value="it.rental_start_at">
                                        <input type="hidden" :name="`items[${idx}][rental_end_at]`"
                                            :value="it.rental_end_at">
                                    </div>
                                </template>
                            </div>
                        </template>

                        {{-- ===== Shipping Info ===== --}}
                        <div class="mt-5 text-left space-y-3">
                            <h4 class="text-amber-100 font-semibold text-sm"><span data-vi="Thông tin giao hàng"
                                    data-en="Shipping Information"></span></h4>

                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                                <div>
                                    <label class="block text-[11px] text-stone-400 mb-1">
                                        <span data-vi="Tên người nhận" data-en="Receiver's Name"></span>
                                    </label>
                                    <input type="text" name="receiver_name" required
                                        class="w-full px-3 py-2 rounded-xl border border-stone-700/60 bg-stone-900/60 text-amber-100
               focus:outline-none focus:ring-2 focus:ring-amber-500"
                                        data-placeholder-vi="Nguyễn Văn A" data-placeholder-en="Nguyen Van A"
                                        value="{{ old('receiver_name') }}" />
                                    @error('receiver_name')
                                        <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div>
                                    <label class="block text-[11px] text-stone-400 mb-1">
                                        <span data-vi="Số điện thoại" data-en="Phone Number"></span>
                                    </label>
                                    <input type="tel" name="receiver_phone" required
                                        class="w-full px-3 py-2 rounded-xl border border-stone-700/60 bg-stone-900/60 text-amber-100
               focus:outline-none focus:ring-2 focus:ring-amber-500"
                                        placeholder="0xxxxxxxxx" value="{{ old('receiver_phone') }}" />
                                    @error('receiver_phone')
                                        <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <div>
                                <label class="block text-[11px] text-stone-400 mb-1">
                                    <span data-vi="Địa chỉ giao hàng" data-en="Shipping Address"></span>
                                </label>
                                <input type="text" name="shipping_address" required
                                    class="w-full px-3 py-2 rounded-xl border border-stone-700/60 bg-stone-900/60 text-amber-100
             focus:outline-none focus:ring-2 focus:ring-amber-500"
                                    data-placeholder-vi="123 Đường ABC, Phường XYZ, Quận 1, TP.HCM"
                                    data-placeholder-en="123 ABC Street, XYZ Ward, District 1, HCM City"
                                    value="{{ old('shipping_address') }}" />
                                @error('shipping_address')
                                    <p class="text-xs text-red-300 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        <button type="button"
                            @click="
    const f = document.getElementById('orderForm');
    if (!f.checkValidity()) {
      f.reportValidity();
      return;
    }
    openOrderConfirm();
  "
                            class="w-full sm:w-auto hp-btn-primary mt-3 px-4 py-3 rounded-xl bg-gradient-to-r
         from-amber-400 via-yellow-500 to-amber-600 text-black font-semibold text-sm">
                            <span data-vi="Đặt hàng" data-en="Place Order"></span>
                        </button>


                        {{-- Modal confirm (ALPINE ONLY) --}}
                        <template x-teleport="body">
                            <div x-cloak x-show="showConfirm"
                                @keydown.escape.window="if(!confirmLoading) showConfirm=false"
                                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm">
                                <!-- overlay click -->
                                <div class="absolute inset-0" @click="if(!confirmLoading) showConfirm=false"></div>

                                <div id="orderConfirmModal"
                                    class="relative bg-stone-900/95 border border-amber-400/30 rounded-3xl p-8 max-w-md w-[92%] text-center"
                                    @click.away="if(!confirmLoading) showConfirm=false">
                                    <h3 class="text-amber-100 text-xl font-semibold mb-3">
                                        <span data-vi="Xác nhận đơn hàng" data-en="Confirm Order"></span>
                                    </h3>

                                    <div
                                        class="text-left space-y-3 bg-stone-800/60 rounded-2xl p-4 border border-amber-400/10 mb-4">
                                        <template x-for="it2 in items.slice(0, 3)" :key="it2.cart_item_id">
                                            <div class="flex justify-between items-center">
                                                <div>
                                                    <p class="text-amber-200 font-medium text-sm" x-text="it2.name">
                                                    </p>
                                                    <p class="text-stone-400 text-xs" x-text="`x${it2.quantity}`"></p>
                                                </div>
                                                <p class="text-amber-300 text-sm font-semibold"
                                                    x-text="formatMoney(lineTotal(it2))"></p>
                                            </div>
                                        </template>

                                        <div
                                            class="border-t border-stone-700/50 pt-3 mt-2 flex justify-between items-center">
                                            <p class="text-stone-400 text-sm">
                                                <span data-vi="Tổng cộng:" data-en="Total:"></span>
                                            </p>
                                            <p class="text-amber-300 text-lg font-bold" x-text="formatMoney(total)">
                                            </p>
                                        </div>
                                    </div>

                                    <div class="flex justify-center gap-4 mt-4">
                                        <!-- Hủy: khóa khi loading -->
                                        <button type="button" @click="if(!confirmLoading) showConfirm=false"
                                            :disabled="confirmLoading"
                                            class="px-5 py-2 rounded-xl text-stone-300 bg-stone-700/40 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span data-vi="Hủy" data-en="Cancel"></span>
                                        </button>

                                        <!-- Xác nhận: có loading -->
                                        <button type="button" :disabled="confirmLoading"
                                            @click="
            if (confirmLoading) return;
            confirmLoading = true;
            const f = document.getElementById('orderForm');
            if (f?.requestSubmit) f.requestSubmit();
            else f.submit();
          "
                                            class="px-6 py-2 rounded-xl bg-gradient-to-r from-amber-400 via-yellow-500 to-amber-600
                 text-black font-semibold disabled:opacity-70 disabled:cursor-not-allowed
                 inline-flex items-center justify-center gap-2 min-w-[140px]">
                                            <template x-if="!confirmLoading">
                                                <span data-vi="Xác nhận" data-en="Confirm"></span>
                                            </template>

                                            <template x-if="confirmLoading">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24"
                                                        fill="none">
                                                        <circle class="opacity-25" cx="12" cy="12"
                                                            r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path>
                                                    </svg>
                                                    <span data-vi="Đang xử lý..." data-en="Processing..."></span>
                                                </span>
                                            </template>
                                        </button>
                                    </div>

                                    <!-- chặn tương tác rõ ràng (optional) -->
                                    <template x-if="confirmLoading">
                                        <p class="mt-3 text-xs text-stone-400/80">
                                            <span data-vi="Vui lòng chờ trong khi chúng tôi xử lý đơn hàng của bạn."
                                                data-en="Please wait while we process your order."></span>
                                        </p>
                                    </template>
                                </div>
                            </div>
                        </template>

                        {{-- ===== Modal confirm REMOVE ONE ===== --}}
                        <template x-teleport="body">
                            <div x-cloak x-show="showRemoveConfirm"
                                @keydown.escape.window="if(!removeLoading) showRemoveConfirm=false"
                                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm">

                                <div class="absolute inset-0" @click="if(!removeLoading) showRemoveConfirm=false">
                                </div>

                                <div id="askRemoveConfirmModal"
                                    class="relative bg-stone-900/95 border border-red-400/30 rounded-3xl p-8 max-w-md w-[92%] text-center"
                                    @click.away="if(!removeLoading) showRemoveConfirm=false">
                                    <h3 class="text-red-200 text-xl font-semibold mb-2">
                                        <span data-vi="Xóa sản phẩm?" data-en="Remove product?"></span>
                                    </h3>
                                    <p class="text-stone-400/80 text-sm mb-5">
                                        <span data-vi="Bạn có chắc muốn xóa"
                                            data-en="Are you sure you want to remove"></span>
                                        <span class="text-amber-200 font-medium" x-text="pendingRemove?.name"></span>
                                        <span data-vi="khỏi giỏ hàng không?" data-en="from the cart?"></span>
                                    </p>

                                    <div class="flex justify-center gap-4">
                                        <button type="button" @click="if(!removeLoading) showRemoveConfirm=false"
                                            :disabled="removeLoading"
                                            class="px-5 py-2 rounded-xl text-stone-300 bg-stone-700/40 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span data-vi="Hủy" data-en="Cancel"></span>
                                        </button>

                                        <button type="button" :disabled="removeLoading" @click="doRemove()"
                                            class="px-6 py-2 rounded-xl bg-gradient-to-r from-red-400 via-rose-500 to-red-600
                       text-black font-semibold disabled:opacity-70 disabled:cursor-not-allowed
                       inline-flex items-center justify-center gap-2 min-w-[140px]">
                                            <template x-if="!removeLoading">
                                                <span data-vi="Xóa" data-en="Remove"></span>
                                            </template>

                                            <template x-if="removeLoading">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24"
                                                        fill="none">
                                                        <circle class="opacity-25" cx="12" cy="12"
                                                            r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path>
                                                    </svg>
                                                    <span data-vi="Đang xóa..." data-en="Removing...">
                                                    </span>
                                            </template>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>

                        {{-- ===== Modal confirm CLEAR ALL ===== --}}
                        <template x-teleport="body">
                            <div x-cloak x-show="showClearConfirm"
                                @keydown.escape.window="if(!clearLoading) showClearConfirm=false"
                                class="fixed inset-0 z-[9999] flex items-center justify-center bg-black/60 backdrop-blur-sm">

                                <div class="absolute inset-0" @click="if(!clearLoading) showClearConfirm=false"></div>

                                <div id="askClearConfirmModal"
                                    class="relative bg-stone-900/95 border border-red-400/30 rounded-3xl p-8 max-w-md w-[92%] text-center"
                                    @click.away="if(!clearLoading) showClearConfirm=false">
                                    <h3 class="text-red-200 text-xl font-semibold mb-2"><span
                                            data-vi="Xóa toàn bộ giỏ hàng?" data-en="Clear entire cart?"></span></h3>
                                    <p class="text-stone-400/80 text-sm mb-5">
                                        <span
                                            data-vi="Hành động này sẽ xóa tất cả sản phẩm trong giỏ hàng. Bạn chắc chứ?"
                                            data-en="This action will remove all products in the cart. Are you sure?"></span>
                                    </p>

                                    <div class="flex justify-center gap-4">
                                        <button type="button" @click="if(!clearLoading) showClearConfirm=false"
                                            :disabled="clearLoading"
                                            class="px-5 py-2 rounded-xl text-stone-300 bg-stone-700/40 disabled:opacity-50 disabled:cursor-not-allowed">
                                            <span data-vi="Hủy" data-en="Cancel"></span>
                                        </button>

                                        <button type="button" :disabled="clearLoading" @click="doClearAll()"
                                            class="px-6 py-2 rounded-xl bg-gradient-to-r from-red-400 via-rose-500 to-red-600
                       text-black font-semibold disabled:opacity-70 disabled:cursor-not-allowed
                       inline-flex items-center justify-center gap-2 min-w-[160px]">
                                            <template x-if="!clearLoading">
                                                <span data-vi="Xóa toàn bộ" data-en="Clear all"></span>
                                            </template>

                                            <template x-if="clearLoading">
                                                <span class="inline-flex items-center gap-2">
                                                    <svg class="w-4 h-4 animate-spin" viewBox="0 0 24 24"
                                                        fill="none">
                                                        <circle class="opacity-25" cx="12" cy="12"
                                                            r="10" stroke="currentColor" stroke-width="4"></circle>
                                                        <path class="opacity-75" fill="currentColor"
                                                            d="M4 12a8 8 0 018-8v3a5 5 0 00-5 5H4z"></path>
                                                    </svg>
                                                    <span data-vi="Đang xóa..." data-en="Clearing...">
                                                    </span>
                                            </template>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </template>
                    </form>
                </div>
            </div>
        </template>

    </div>

    <style>
        @keyframes shake {

            0%,
            100% {
                transform: translateX(0)
            }

            25% {
                transform: translateX(-6px)
            }

            50% {
                transform: translateX(6px)
            }

            75% {
                transform: translateX(-4px)
            }
        }

        .animate-shake {
            animation: shake 0.4s ease-in-out;
        }

        [x-cloak] {
            display: none !important;
        }
    </style>
</div>
