<div wire:poll.60s="loadStats"
    class="mt-16 border-t border-gray-200 dark:border-gray-700 pt-8">
    <div
        class="bg-white dark:bg-gray-800 rounded-2xl p-6 shadow-sm border border-gray-100 dark:border-gray-700">
        <section aria-labelledby="today-summary" class="max-w-5xl mx-auto">
            <header class="mb-5 flex items-center gap-3">
                <span
                    class="inline-block h-2.5 w-2.5 rounded-full bg-gradient-to-br from-blue-500 to-indigo-500 ring-4 ring-blue-100/70 dark:ring-blue-900/30">
                </span>
                <h2 id="today-summary"
                    class="text-base md:text-lg font-semibold tracking-tight text-gray-900 dark:text-gray-100">
                    Today’s Summary
                </h2>
            </header>

            <section class="w-full">
                <div class="max-w-6xl mx-auto px-4 md:px-6">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 md:gap-6 place-items-center">

                        {{-- Orders Processed --}}
                        <article
                            class="group relative overflow-hidden rounded-2xl border border-gray-200/70 dark:border-gray-700/60
                            bg-gray-50/70 dark:bg-gray-800/50 p-4 md:p-5 transition-all
                            hover:-translate-y-0.5 hover:shadow-lg w-full max-w-sm">
                            <div
                                class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity
                                bg-gradient-to-br from-blue-500/5 via-transparent to-transparent">
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="h-6 w-6 md:h-7 md:w-7 text-blue-600 dark:text-blue-400"
                                        viewBox="0 0 24 24" fill="none">
                                        <path d="M4 7h16M4 12h16M4 17h10" stroke="currentColor"
                                            stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" />
                                    </svg>
                                    <span class="text-sm text-gray-700/90 dark:text-gray-300">
                                        Orders Processed
                                    </span>
                                </div>
                                <div class="text-right text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                                    {{ $ordersProcessed }}
                                </div>
                            </div>
                        </article>

                        {{-- Revenue Generated --}}
                        <article
                            class="group relative overflow-hidden rounded-2xl border border-gray-200/70 dark:border-gray-700/60
                            bg-gray-50/70 dark:bg-gray-800/50 p-4 md:p-5 transition-all
                            hover:-translate-y-0.5 hover:shadow-lg w-full max-w-sm">
                            <div
                                class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity
                                bg-gradient-to-br from-emerald-500/5 via-transparent to-transparent">
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="h-6 w-6 md:h-7 md:w-7 text-emerald-600 dark:text-emerald-400"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M12 3v18M6 7c1.5-1.5 3.5-2 6-2s4.5.5 6 2M6 17c1.5 1.5 3.5 2 6 2s4.5-.5 6-2"
                                            stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" />
                                    </svg>
                                    <span class="text-sm text-gray-700/90 dark:text-gray-300">
                                        Revenue Generated
                                    </span>
                                </div>
                                <div class="text-right text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                                    {{ $revenueGenerated }} Đ
                                </div>
                            </div>
                        </article>

                        {{-- Active Users --}}
                        <article
                            class="group relative overflow-hidden rounded-2xl border border-gray-200/70 dark:border-gray-700/60
                            bg-gray-50/70 dark:bg-gray-800/50 p-4 md:p-5 transition-all
                            hover:-translate-y-0.5 hover:shadow-lg w-full max-w-sm">
                            <div
                                class="pointer-events-none absolute inset-0 opacity-0 group-hover:opacity-100 transition-opacity
                                bg-gradient-to-br from-violet-500/5 via-transparent to-transparent">
                            </div>

                            <div class="flex items-center justify-between">
                                <div class="flex items-center gap-3">
                                    <svg class="h-6 w-6 md:h-7 md:w-7 text-violet-600 dark:text-violet-400"
                                        viewBox="0 0 24 24" fill="none">
                                        <path
                                            d="M12 12a4 4 0 1 0-4-4 4 4 0 0 0 4 4Zm0 2c-4 0-7 2-7 4v1h14v-1c0-2-3-4-7-4Z"
                                            stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span class="text-sm text-gray-700/90 dark:text-gray-300">
                                        Active Users
                                    </span>
                                </div>
                                <div class="text-right text-xl md:text-2xl font-bold tracking-tight text-gray-900 dark:text-gray-100">
                                    {{ $activeUsers }}
                                </div>
                            </div>
                        </article>
                    </div>
                </div>
            </section>
        </section>

        {{-- Footer Bottom --}}
        <div
            class="mt-6 pt-6 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-500 dark:text-gray-400">
                    © 2025 Shop Wizard. Made with ❤️ in Vietnam
                </div>
                <div class="flex items-center space-x-2">
                    <div class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></div>
                    <span class="text-xs text-green-600 dark:text-green-400 font-medium">v2.1.0</span>
                </div>
            </div>
            <div class="flex items-center space-x-3">
                <button
                    class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Privacy</button>
                <button
                    class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Terms</button>
                <button
                    class="text-xs text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300 transition-colors">Support</button>
            </div>
        </div>
    </div>
</div>
