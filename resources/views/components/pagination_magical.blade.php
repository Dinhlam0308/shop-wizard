@if ($paginator->hasPages())
    <nav role="navigation" aria-label="Pagination" 
         class="flex justify-center items-center gap-3 px-12 py-12 select-none">

        {{-- Previous Page Link --}}
        @if ($paginator->onFirstPage())
            <span class="p-2.5 rounded-2xl bg-white/20 dark:bg-white/5 
                         text-gray-400 border border-white/10 
                         backdrop-blur-xl cursor-not-allowed">
                <i data-lucide="chevron-left" class="w-5 h-5"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}" rel="prev"
               class="p-2.5 rounded-2xl bg-white/80 dark:bg-[#101010]/70 text-gray-700 dark:text-gray-200
                      border border-gray-300/40 dark:border-gray-700/50
                      hover:text-amber-500 hover:scale-105 hover:shadow-[0_0_12px_rgba(255,215,0,0.25)]
                      backdrop-blur-2xl transition-all duration-400 ease-out">
                <i data-lucide="chevron-left" class="w-5 h-5"></i>
            </a>
        @endif

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- Dấu “...” --}}
            @if (is_string($element))
                <span class="px-3 py-2 text-sm text-gray-500 dark:text-gray-400">…</span>
            @endif

            {{-- Các trang --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span
                            class="px-4 py-2.5 rounded-2xl font-semibold text-white 
                                   bg-gradient-to-r from-amber-400 via-yellow-400 to-rose-400 
                                   border border-amber-400/60 shadow-[0_0_25px_rgba(255,215,0,0.3)]
                                   backdrop-blur-2xl scale-105 transition-all duration-500 ease-out">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}" 
                           class="px-4 py-2.5 rounded-2xl text-gray-700 dark:text-gray-300 
                                  bg-white/80 dark:bg-[#1a1b1f]/80 border border-gray-200/50 dark:border-gray-700/50
                                  hover:text-amber-500 hover:border-amber-400/60
                                  hover:shadow-[0_0_20px_rgba(255,215,0,0.25)] 
                                  transition-all duration-500 backdrop-blur-xl hover:scale-[1.07]">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}" rel="next"
               class="p-2.5 rounded-2xl bg-white/80 dark:bg-[#101010]/70 text-gray-700 dark:text-gray-200
                      border border-gray-300/40 dark:border-gray-700/50
                      hover:text-amber-500 hover:scale-105 hover:shadow-[0_0_12px_rgba(255,215,0,0.25)]
                      backdrop-blur-2xl transition-all duration-400 ease-out">
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </a>
        @else
            <span class="p-2.5 rounded-2xl bg-white/20 dark:bg-white/5 text-gray-400 
                         border border-white/10 backdrop-blur-xl cursor-not-allowed">
                <i data-lucide="chevron-right" class="w-5 h-5"></i>
            </span>
        @endif
    </nav>

    {{-- Kích hoạt Lucide icons --}}
    <script> lucide.createIcons(); </script>
@endif
