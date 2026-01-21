<div wire:poll.10s="refresh" class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">

    <!-- Sales Trend -->
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                    Sales Trend
                </h4>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">
                    {{ number_format($sales, 0) }} Đ
                </p>
                <div class="flex items-center space-x-1 mt-1">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-600 dark:text-green-400 font-medium">
                        +{{ $salesChange }}% vs last week
                    </span>
                </div>
            </div>

            <div x-data="{
                points: @js(array_values($sales7Days)),
                get path() { return generatePath(this.points) }
            }"
                class="w-16 h-16 flex items-center justify-center bg-gradient-to-br from-white to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl shadow-inner hover:shadow-xl transition-all duration-700 ease-in-out">
                <script>
                    function generatePath(points) {
                        if (!points || points.length === 0) return "";

                        const maxY = Math.max(...points);
                        const scaleY = 40 / maxY;
                        const startY = 60 - points[0] * scaleY;
                        let path = `M5,${startY}`;

                        for (let i = 1; i < points.length; i++) {
                            const x = 5 + i * 9; 
                            const y = 60 - points[i] * scaleY;
                            path += ` T${x},${y}`;
                        }

                        return path;
                    }
                </script>

                <svg class="w-5/6 h-5/6" viewBox="0 0 64 64">
                    <defs>
                        <linearGradient id="salesGradient" x1="0%" y1="0%" x2="0%" y2="100%">
                            <stop offset="0%" style="stop-color:#10B981;stop-opacity:0.3" />
                            <stop offset="100%" style="stop-color:#10B981;stop-opacity:0" />
                        </linearGradient>
                    </defs>

                    <path :d="path" stroke="#10B981" stroke-width="2" fill="none" stroke-linecap="round"
                        class="animate-draw" />

                    <path :d="`${path} L60,60 L5,60 Z`" fill="url(#salesGradient)" />
                </svg>
            </div>

        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400">Last 7 days performance</div>
    </div>

    <!-- Order Volume -->
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300">
        <div class="flex items-center justify-between mb-4">
            <div>
                <h4 class="text-sm font-semibold text-gray-600 dark:text-gray-400 uppercase tracking-wider">
                    Order Volume
                </h4>
                <p class="text-2xl font-bold text-gray-900 dark:text-gray-100 mt-1">{{ $orders }}</p>
                <div class="flex items-center space-x-1 mt-1">
                    <div class="w-2 h-2 bg-blue-400 rounded-full animate-pulse"></div>
                    <span class="text-xs text-blue-600 dark:text-blue-400 font-medium">
                        +{{ $orderChange }}% vs yesterday
                    </span>
                </div>
            </div>

            <div x-data="{ bars: @js($bars) }"
                class="w-28 h-20 flex items-end justify-between space-x-1 bg-gradient-to-br from-white to-gray-100 dark:from-gray-800 dark:to-gray-900 rounded-2xl p-2 shadow-inner hover:shadow-xl transition-all duration-700 ease-in-out">
                <template x-for="(height, date) in bars" :key="date">
                    <div class="flex flex-col items-center relative group cursor-pointer">
                        <div
                            class="absolute bottom-full mb-2 px-2 py-1 bg-gray-900 text-white text-[9px] rounded-xl opacity-0 group-hover:opacity-100 group-hover:translate-y-[-2px] transition-all duration-300 ease-in-out shadow-lg">
                            <span x-text="height + '%'"></span>
                        </div>

                        <div class="relative w-4 rounded-t-2xl overflow-hidden bg-gradient-to-t from-blue-500 via-sky-400 to-cyan-300 shadow-md transition-all duration-700 ease-out group-hover:scale-105 group-hover:shadow-blue-300/50"
                            :style="`height:${Math.max(6, height / 100 * 48)}px`">
                            <div class="absolute inset-0 bg-white/10 group-hover:bg-white/20 transition-all"></div>
                        </div>

                        <span
                            class="text-[9px] mt-1 text-gray-500 dark:text-gray-400 group-hover:text-blue-500 font-medium transition-colors"
                            x-text="date"></span>
                    </div>
                </template>
            </div>
        </div>
        <div class="text-xs text-gray-500 dark:text-gray-400">Orders this week</div>
    </div>
</div>
