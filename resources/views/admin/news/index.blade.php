<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
                {{ __('News') }}
            </h2>

            <a href="{{ route('admin.news.create') }}"
                class="inline-flex items-center px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600
                      text-sm font-semibold rounded-xl text-gray-700 dark:text-gray-200 
                      bg-transparent hover:bg-gray-800 dark:hover:bg-gray-700 
                      hover:text-white hover:border-gray-800 dark:hover:border-gray-500
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 
                      transition-all duration-300 ease-in-out backdrop-blur-sm">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                <span class="hidden sm:inline">Create</span>
                <span class="sr-only sm:not-sr-only">Create</span>
            </a>
        </div>
    </x-slot>

    <div
        class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifications --}}
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif
            @if (session('error'))
                <x-notification type="error" :message="session('error')" />
            @endif

            <div
                class="rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 
                       bg-white/80 dark:bg-gray-800/80 backdrop-blur-md shadow-2xl 
                       transition-all duration-500 ease-in-out">

                {{-- Search Bar --}}
                <div class="mx-4 my-4">
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
                        <form method="GET" action="{{ route('admin.news.index') }}"
                            class="w-full sm:w-auto flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <div class="flex-1 sm:w-96">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Search by ID…"
                                    class="w-full px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                                              bg-white/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100
                                              placeholder-gray-400 dark:placeholder-gray-500
                                              focus:ring-2 focus:ring-gray-600 focus:outline-none transition-all" />
                            </div>
                            <div class="flex gap-2">
                                <button type="submit"
                                    class="px-4 py-2 rounded-xl text-sm font-semibold text-white 
                                               bg-gray-900 dark:bg-gray-200 dark:text-gray-900 
                                               hover:scale-[1.03] transition-all duration-300">
                                    Search
                                </button>
                                @if (request('search'))
                                    <a href="{{ route('admin.news.index') }}"
                                        class="px-4 py-2 rounded-xl text-sm font-semibold border border-gray-300 dark:border-gray-600
                                              text-gray-600 dark:text-gray-300 hover:bg-gray-100 dark:hover:bg-gray-700
                                              transition">
                                        ✕ Clear
                                    </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>

                {{-- ===================== Mobile Cards (<sm) ===================== --}}
                <div class="sm:hidden px-4 pb-4">
                    @forelse($news as $item)
                        <article
                            class="mb-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80
                                   p-4 shadow-sm hover:shadow-md transition"
                            x-data="{ showImg: false, copied: false }">
                            <div class="flex items-start gap-3">
                                <button type="button" class="shrink-0" @click="showImg = true"
                                    aria-label="Preview image">
                                    @if ($item->image)
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                            class="w-16 h-16 object-cover rounded-xl ring-1 ring-gray-200 dark:ring-gray-700">
                                    @else
                                        <div
                                            class="w-16 h-16 rounded-xl bg-gray-100 dark:bg-gray-700 grid place-items-center text-xs text-gray-500">
                                            No Image</div>
                                    @endif
                                </button>

                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 truncate">
                                        #{{ $item->id }} · {{ \Illuminate\Support\Str::limit($item->title, 70) }}
                                    </h3>

                                    <div class="mt-1 flex items-center gap-2" x-data="{ s: @js($item->slug), copiedSlug: false, copy() { navigator.clipboard.writeText(this.s);
                                            this.copiedSlug = true;
                                            setTimeout(() => this.copiedSlug = false, 1200); } }">
                                        <span class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[220px]">
                                            {{ \Illuminate\Support\Str::limit($item->slug, 48) }}
                                        </span>
                                        <button type="button" @click="copy()"
                                            class="px-2 py-0.5 text-[11px] rounded border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                            Copy slug
                                        </button>
                                        <span class="text-[11px] text-green-600 dark:text-green-400" x-cloak x-show="copiedSlug"
                                            x-transition.opacity>Copied</span>
                                    </div>

                                    <div class="mt-3 flex items-center gap-2">
                                        <a href="{{ route('admin.news.edit', $item->id) }}"
                                            class="inline-flex items-center justify-center rounded-lg border border-blue-300 dark:border-blue-600
                                                  px-3 py-2 text-xs font-medium text-blue-600 dark:text-blue-400
                                                  hover:bg-blue-600 dark:hover:bg-blue-500 hover:text-white transition">
                                            Edit
                                        </a>
                                        <form action="{{ route('admin.news.destroy', $item->id) }}" method="POST"
                                            onsubmit="return confirm('Are you sure you want to delete this article?');">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="inline-flex items-center justify-center rounded-lg border border-red-300 dark:border-red-600
                                                           px-3 py-2 text-xs font-medium text-red-600 dark:text-red-400
                                                           hover:bg-red-600 dark:hover:bg-red-500 hover:text-white transition">
                                                Delete
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            {{-- Image Modal --}}
                            @if ($item->image)
                                <div x-cloak x-cloak x-show="showImg" x-transition.opacity
                                    class="fixed inset-0 z-50 bg-black/60 p-6" @click.self="showImg=false">
                                    <div class="max-w-2xl mx-auto">
                                        <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                            class="w-full rounded-2xl shadow-2xl">
                                        <button type="button"
                                            class="mt-3 w-full rounded-xl bg-white/90 dark:bg-gray-800/80 py-2 text-sm"
                                            @click="showImg=false">Close</button>
                                    </div>
                                </div>
                            @endif
                        </article>
                    @empty
                        <div class="px-2 py-10 text-center text-gray-400 dark:text-gray-500">
                            <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 9h8m-8 4h6m9 5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z" />
                            </svg>
                            <p class="text-lg font-medium">No news articles found</p>
                            <p class="text-sm">Get started by creating your first article.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ===================== Desktop Table (sm+) ===================== --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[1024px] w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="sticky top-0 z-10 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 border-b border-gray-300 dark:border-gray-700">
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-20">
                                        ID</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        Title</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">
                                        Slug</th>
                                    <th
                                        class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-28">
                                        Image</th>
                                    <th
                                        class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[18%]">
                                        Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($news as $item)
                                    <tr
                                        class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/70 hover:shadow-md transition-all duration-300 ease-in-out">
                                        <td
                                            class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                            #{{ $item->id }}</td>

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                {{ Str::limit($item->title, 80) }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-2" x-data="{ s: @js($item->slug), copied: false, copy() { navigator.clipboard.writeText(this.s);
                                                    this.copied = true;
                                                    setTimeout(() => this.copied = false, 1200); } }">
                                                <span
                                                    class="text-gray-700 dark:text-gray-300 truncate max-w-[320px]">{{ Str::limit($item->slug, 60) }}</span>
                                                <button type="button" @click="copy()"
                                                    class="px-2 py-1 text-[11px] rounded-lg border border-gray-300 dark:border-gray-600
                                                               text-gray-700 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                                    Copy
                                                </button>
                                                <span class="text-[11px] text-green-600 dark:text-green-400"
                                                    x-cloak x-show="copied" x-transition.opacity>Copied</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            @if ($item->image)
                                                <a href="{{ $item->image }}" target="_blank" rel="noopener noreferrer" class="inline-block">
                                                    <img src="{{ $item->image }}" alt="{{ $item->title }}"
                                                        class="w-12 h-12 object-cover rounded-lg ring-1 ring-gray-200 dark:ring-gray-700">
                                                </a>
                                            @else
                                                <span class="text-gray-400 dark:text-gray-500">No Image</span>
                                            @endif
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <a href="{{ route('admin.news.edit', $item->id) }}"
                                                    class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                                          text-xs font-medium rounded-lg text-blue-600 dark:text-blue-400 
                                                          hover:bg-blue-600 dark:hover:bg-blue-500 hover:text-white transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414 a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>

                                                <form action="{{ route('admin.news.destroy', $item->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Are you sure you want to delete this article?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" x-data="loadingButton"
                                                        @click="handleClick" data-loading
                                                        class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                                   hover:bg-red-600 dark:hover:bg-red-500 hover:text-white 
                                                                   transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                                    a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4
                                                                    a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 dark:text-gray-500">
                                                <svg class="mx-auto h-12 w-12 mb-4" fill="none"
                                                    stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-medium">No news articles found</p>
                                                <p class="text-sm">Get started by creating your first article.</p>
                                            </div>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
                {{-- ===================== /Desktop Table ===================== --}}
            </div>

            {{-- Pagination --}}
            <div class="mt-6 text-gray-700 dark:text-gray-300">
                {{ $news->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
