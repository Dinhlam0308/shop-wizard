<!-- Recent Activity -->
<div class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100">Recent Activity</h3>
        <div class="flex items-center space-x-3">
            <div class="flex items-center space-x-2">
                <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                <span class="text-sm text-green-600 dark:text-green-400 font-medium text-xs">Live</span>
            </div>
            <a href="#" class="text-sm text-blue-600 hover:text-blue-800 font-medium">View all
                →</a>
        </div>
    </div>

    <div wire:poll.30s="loadActivities" class="space-y-1" x-data="{
        activities: {{ Js::from($activities) }},
        markAsRead(id) {
            this.activities = this.activities.map(a => a.id === id ? { ...a, isNew: false } : a)
        }
    }" x-init="console.log('📊 Loaded activities:', activities)">
        <template x-for="(activity, index) in activities" :key="activity.id">
            <div class="group flex items-center space-x-4 p-4 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-all duration-300 hover:scale-[1.02] hover:shadow-md cursor-pointer"
                :class="activity.isNew ?
                    'bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800' :
                    'bg-gray-50 dark:bg-gray-700'"
                :style="`animation-delay: ${index * 100}ms`">

                <!-- Timeline Dot -->
                <div class="relative">
                    <div class="w-10 h-10 rounded-full flex items-center justify-center transition-all duration-300 group-hover:scale-110"
                        :class="activity.iconBg">
                        <svg class="w-5 h-5" :class="activity.iconColor" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                :d="activity.icon" />
                        </svg>
                    </div>
                    <div x-cloak x-show="activity.isNew"
                        class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full animate-ping">
                    </div>
                    <div x-cloak x-show="activity.isNew" class="absolute -top-1 -right-1 w-3 h-3 bg-red-500 rounded-full"></div>
                </div>

                <!-- Content -->
                <div class="flex-1 min-w-0">
                    <div class="flex items-start justify-between">
                        <div class="flex-1">
                            <p class="text-sm font-medium text-gray-900 dark:text-gray-100 group-hover:text-blue-600 dark:group-hover:text-blue-400 transition-colors"
                                x-text="activity.title"></p>
                            <p class="text-xs text-gray-500 dark:text-gray-400 mt-1 leading-relaxed"
                                x-text="activity.description"></p>
                            <div class="flex items-center space-x-3 mt-2">
                                <span class="text-xs font-medium px-2 py-1 rounded-full"
                                    :class="activity.statusBg + ' ' + activity.statusText"
                                    x-text="activity.status"></span>
                                <span class="text-xs text-gray-400 dark:text-gray-500" x-text="activity.time"></span>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2 ml-4">
                            <button
                                class="opacity-0 group-hover:opacity-100 p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-all duration-200"
                                @click.stop="markAsRead(activity.id)">
                                <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7" />
                                </svg>
                            </button>
                            <button
                                class="opacity-0 group-hover:opacity-100 p-2 hover:bg-gray-100 dark:hover:bg-gray-600 rounded-lg transition-all duration-200">
                                <svg class="w-4 h-4 text-gray-400 hover:text-gray-600 dark:hover:text-gray-300"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z" />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </template>

        <!-- Loading Animation -->
        <div x-cloak x-show="isLoading" class="flex items-center justify-center py-8">
            <div class="flex space-x-1">
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse"></div>
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse" style="animation-delay: 0.1s"></div>
                <div class="w-2 h-2 bg-blue-500 rounded-full animate-pulse" style="animation-delay: 0.2s"></div>
            </div>
        </div>
    </div>
</div>
