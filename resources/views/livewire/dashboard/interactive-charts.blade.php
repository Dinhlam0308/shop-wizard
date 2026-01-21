<script>
    function interactiveCharts(chartData) {
        return {
            charts: [],
            draggedIndex: null,

            initCharts() {
                console.log('📊 Raw chartData from backend:', chartData);
                const revenueData = Object.entries(chartData.revenue || {}).map(([date, value]) => ({
                    x: date,
                    y: value
                }));

                const userData = Object.entries(chartData.users || {}).map(([date, value]) => ({
                    x: date,
                    y: value
                }));

                const productData = Object.entries(chartData.products || {}).map(([date, value]) => ({
                    x: date,
                    y: value
                }));

                console.log('📈 Parsed Revenue Data:', revenueData);
                console.log('👥 Parsed User Data:', userData);
                console.log('📦 Parsed Product Data:', productData);

                const hasRevenue = revenueData.length > 0;
                const hasUsers = userData.length > 0;
                const hasProducts = productData.length > 0;

                this.charts = [{
                        id: 1,
                        title: 'Revenue Trend',
                        subtitle: 'Total Sales',
                        type: 'line',
                        value: hasRevenue ? `$${revenueData.at(-1)?.y}` : 'No data',
                        change: hasRevenue ? `${this.calculateChange(revenueData)}%` : '--',
                        period: 'All time',
                        lastUpdated: new Date().toLocaleTimeString(),
                        color: '#3B82F6',
                        pathData: hasRevenue ? this.generatePathFromData(revenueData) : '',
                        hasData: hasRevenue,
                        icon: 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6',
                        iconBg: 'bg-blue-100 dark:bg-blue-900',
                        iconColor: 'text-blue-600 dark:text-blue-400',
                        valueColor: 'text-blue-600 dark:text-blue-400',
                        changeColor: 'text-green-600 dark:text-green-400',
                        statusColor: 'bg-green-400',
                        expanded: false,
                    },
                    {
                        id: 2,
                        title: 'User Growth',
                        subtitle: 'New Registrations',
                        type: 'line',
                        value: hasUsers ? userData.at(-1)?.y : 'No data',
                        change: hasUsers ? `${this.calculateChange(userData)}%` : '--',
                        period: 'All time',
                        lastUpdated: new Date().toLocaleTimeString(),
                        color: '#8B5CF6',
                        pathData: hasUsers ? this.generatePathFromData(userData) : '',
                        hasData: hasUsers,
                        icon: 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20a3 3 0 01-3-3v-2a3 3 0 013-3h10a3 3 0 013 3v2a3 3 0 01-3 3m-8-5a3 3 0 116 0 3 3 0 01-6 0z',
                        iconBg: 'bg-purple-100 dark:bg-purple-900',
                        iconColor: 'text-purple-600 dark:text-purple-400',
                        valueColor: 'text-purple-600 dark:text-purple-400',
                        changeColor: parseFloat(this.calculateChange(userData)) > 0 ?
                            'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400',
                        statusColor: 'bg-purple-400',
                        expanded: false,
                    },
                    {
                        id: 3,
                        title: 'Product Count',
                        subtitle: 'Available Items',
                        type: 'bar',
                        value: hasProducts ? productData.at(-1)?.y : 'No data',
                        change: hasProducts ? `${this.calculateChange(productData)}%` : '--',
                        period: 'All time',
                        lastUpdated: new Date().toLocaleTimeString(),
                        color: '#10B981',
                        bars: hasProducts ? this.generateBarFromCount(productData) : [],
                        hasData: hasProducts,
                        icon: 'M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z',
                        iconBg: 'bg-green-100 dark:bg-green-900',
                        iconColor: 'text-green-600 dark:text-green-400',
                        valueColor: 'text-green-600 dark:text-green-400',
                        changeColor: 'text-green-600 dark:text-green-400',
                        statusColor: 'bg-green-400',
                        expanded: false,
                    }
                ];
            },

            generatePathFromData(data) {
                if (data.length < 2) return '';
                const maxY = Math.max(...data.map(d => d.y));
                const minY = Math.min(...data.map(d => d.y));
                const scale = 100 / (maxY - minY || 1);
                const step = 300 / (data.length - 1);
                let path = `M0,${100 - (data[0].y - minY) * scale}`;

                for (let i = 1; i < data.length; i++) {
                    const prevX = (i - 1) * step;
                    const prevY = 100 - (data[i - 1].y - minY) * scale;
                    const x = i * step;
                    const y = 100 - (data[i].y - minY) * scale;
                    const controlX = (prevX + x) / 2;
                    path += ` Q${controlX},${prevY} ${x},${y}`;
                }
                return path;
            },

            calculateChange(data) {
                if (!Array.isArray(data) || data.length < 2) return 0;

                const last = data.at(-1).y;
                const others = data.slice(0, -1).map(d => d.y);
                const avg = others.reduce((a, b) => a + b, 0) / others.length;

                if (!avg) return 0;
                return ((last - avg) / avg * 100).toFixed(1);
            },

            generateBarFromCount(data) {
                if (!Array.isArray(data) || data.length === 0) return [];

                const maxY = Math.max(...data.map(d => d.y));
                const minY = Math.min(...data.map(d => d.y));
                const range = maxY - minY || 1;

                console.log('🎨 Bars generated:', data.map(d => ((d.y - Math.min(...data.map(d => d.y))) / ((Math.max(
                    ...data.map(d => d.y)) - Math.min(...data.map(d => d.y))) || 1)) * 100));
                return data.map(d => ({
                    height: Math.max(15, ((d.y - minY) / range) * 100),
                    tooltip: `Value: ${d.y}`
                }));
            },

            dragStart(index, event) {
                this.draggedIndex = index;
                event.dataTransfer.effectAllowed = 'move';
                event.target.style.opacity = '0.5';
            },

            drop(index, event) {
                event.preventDefault();
                if (this.draggedIndex !== null && this.draggedIndex !== index) {
                    const draggedChart = this.charts[this.draggedIndex];
                    this.charts.splice(this.draggedIndex, 1);
                    this.charts.splice(index, 0, draggedChart);
                }
                this.draggedIndex = null;
                document.querySelectorAll('[draggable="true"]').forEach(el => el.style.opacity = '1');
            },

            refreshCharts() {
                this.initCharts();
            }
        }
    }
</script>
<div class="mb-12" x-data="interactiveCharts(@js($chartData))" x-init="initCharts()" wire:poll.5s="refresh">
    <div class="flex items-center justify-between mb-8">
        <div>
            <h3 class="text-2xl font-bold text-gray-900 dark:text-gray-100 flex items-center space-x-3">
                <div
                    class="w-8 h-8 bg-gradient-to-r from-blue-500 to-cyan-500 rounded-xl flex items-center justify-center">
                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2v-8a2 2 0 012-2h2a2 2 0 012 2v10a2 2 0 01-2 2h-2a2 2 0 01-2-2z" />
                    </svg>
                </div>
                <span>Interactive Analytics</span>
            </h3>
            <p class="text-gray-600 dark:text-gray-400 mt-1">Drag & drop to customize • Real-time
                updates</p>
        </div>
        <div class="flex items-center space-x-3">
            <button @click="refreshCharts()"
                class="flex items-center space-x-2 px-4 py-2 bg-blue-100 dark:bg-blue-900 text-blue-700 dark:text-blue-300 rounded-xl hover:bg-blue-200 dark:hover:bg-blue-800 transition-colors duration-200">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                </svg>
                <span class="text-sm font-medium">Refresh</span>
            </button>
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-ping"></div>
                <span class="text-sm text-green-600 dark:text-green-400 font-medium">Live Data</span>
            </div>
        </div>
    </div>

    <!-- Draggable Chart Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6" x-ref="chartGrid">
        <template x-for="(chart, index) in charts" :key="chart.id">
            <div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all duration-300 cursor-move animate-float3d"
                :class="chart.size === 'large' ? 'lg:col-span-2' : ''" draggable="true"
                @dragstart="dragStart(index, $event)" @dragover.prevent @drop="drop(index, $event)"
                :style="`animation-delay: ${index * 100}ms`">

                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" :class="chart.iconBg">
                            <svg class="w-5 h-5" :class="chart.iconColor" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    :d="chart.icon" />
                            </svg>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-gray-900 dark:text-gray-100" x-text="chart.title"></h4>
                            <p class="text-xs text-gray-500 dark:text-gray-400" x-text="chart.subtitle"></p>
                        </div>
                    </div>
                    <div class="flex items-center space-x-2">
                        <button @click="chart.expanded = !chart.expanded"
                            class="p-2 hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg transition-colors">
                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                        </button>
                        <div class="w-2 h-2 rounded-full animate-pulse" :class="chart.statusColor">
                        </div>
                    </div>
                </div>

                <!-- Chart Content -->
                <div class="relative" :class="chart.expanded ? 'h-64' : 'h-32'">
                    <!-- Line Chart Simulation -->
                    <div x-cloak x-show="chart.type === 'line'" class="w-full h-full relative">
                        <template x-if="chart.hasData">
                            <svg class="w-full h-full" viewBox="0 0 300 120">
                                <path :d="chart.pathData" :stroke="chart.color" stroke-width="3" fill="none"
                                    stroke-linecap="round" class="animate-pulse" />
                            </svg>
                        </template>
                        {{-- Change Indicator --}}
                        <template x-if="chart.change !== '--'">
                            <div
                                class="absolute top-2 right-2 flex items-center space-x-1 bg-white/5 dark:bg-gray-800/5 px-2 py-1 rounded-full backdrop-blur-sm">
                                <div :class="chart.changeColor" class="w-3 h-3 rounded-full"></div>
                                <div :class="chart.changeColor" class="text-sm font-medium" x-text="chart.change">
                                </div>
                            </div>
                        </template>
                        <template x-if="!chart.hasData">
                            <div
                                class="flex items-center justify-center h-full text-gray-400 dark:text-gray-500 text-sm italic">
                                No data available
                            </div>
                        </template>
                    </div>

                    <!-- Bar Chart Simulation -->
                    <div x-cloak x-show="chart.type === 'bar'" class="w-full h-full relative">
                        <template x-if="chart.hasData">
                            <div class="absolute bottom-0 left-0 right-0 flex items-end space-x-1 h-full px-2">
                                <template x-for="(bar, barIndex) in chart.bars" :key="barIndex">
                                    <div class="relative group">
                                        <div class="w-6 bg-green-500 rounded-t-lg transition-all duration-300"
                                            :style="`height: ${bar.height}px; background-color: ${chart.color}`"></div>
                                        <div
                                            class="absolute -top-6 left-1/2 transform -translate-x-1/2 bg-gray-900 text-white text-xs rounded px-2 py-1 opacity-0 group-hover:opacity-100 transition-opacity">
                                            <span x-text="bar.tooltip"></span>
                                        </div>
                                    </div>
                                </template>
                            </div>
                        </template>
                        {{-- Change Indicator --}}
                        <template x-if="chart.change !== '--'">
                            <div
                                class="absolute top-2 right-2 flex items-center space-x-1 bg-white/5 dark:bg-gray-800/5 px-2 py-1 rounded-full backdrop-blur-sm">
                                <div :class="chart.changeColor" class="w-3 h-3 rounded-full"></div>
                                <div :class="chart.changeColor" class="text-sm font-medium" x-text="chart.change">
                                </div>
                            </div>
                        </template>
                        <template x-if="!chart.hasData">
                            <div
                                class="flex items-center justify-center h-full text-gray-400 dark:text-gray-500 text-sm italic">
                                No data available
                            </div>
                        </template>
                    </div>
                </div>

                <!-- Chart Footer -->
                <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700">
                    <div class="flex items-center justify-between text-xs text-gray-500 dark:text-gray-400">
                        <span x-text="chart.period"></span>
                        <span>Updated <span x-text="chart.lastUpdated"></span></span>
                    </div>
                </div>
            </div>
        </template>
    </div>
</div>
