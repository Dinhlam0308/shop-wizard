<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight tracking-tight">
                {{ __('Contact') }}
            </h2>
            <a href="{{ route('admin.contact.create') }}"
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

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
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
                        <form method="GET" action="{{ route('admin.contact.index') }}"
                              class="w-full sm:w-auto flex flex-col sm:flex-row gap-2 sm:gap-3">
                            <div class="flex-1 sm:w-80">
                                <input type="text" name="search" value="{{ request('search') }}"
                                       placeholder="Search by ID, name, email, or message…"
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
                                    <a href="{{ route('admin.contact.index') }}"
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
                    @forelse($contacts as $contact)
                        <article
                            class="mb-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80
                                   p-4 shadow-sm hover:shadow-md transition" x-data="{open:false,copied:false}">
                            <header class="flex items-start justify-between gap-3">
                                <div class="min-w-0">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100">
                                        #{{ $contact->id }} · {{ \Illuminate\Support\Str::limit($contact->name, 40) }}
                                    </h3>
                                    <div class="flex items-center gap-2 mt-1">
                                        <a href="mailto:{{ $contact->email }}?subject={{ urlencode('[Always Café] Reply to your message #'.$contact->id) }}"
                                           class="text-sm text-blue-600 dark:text-blue-400 hover:underline truncate max-w-[220px]">
                                           {{ \Illuminate\Support\Str::limit($contact->email, 38) }}
                                        </a>
                                        <button type="button"
                                                @click="navigator.clipboard.writeText(@js($contact->email)); copied=true; setTimeout(()=>copied=false,1200)"
                                                class="px-2 py-0.5 text-[11px] rounded border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                            Copy
                                        </button>
                                        <span class="text-[11px] text-green-600 dark:text-green-400" x-cloak x-show="copied" x-transition.opacity>Copied</span>
                                    </div>
                                </div>
                                <button type="button" @click="open=!open"
                                        class="shrink-0 px-3 py-1.5 text-xs rounded-lg border border-gray-300 dark:border-gray-600 text-gray-700 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                    <span x-cloak x-show="!open">Preview</span>
                                    <span x-cloak x-show="open">Hide</span>
                                </button>
                            </header>

                            <p class="mt-3 text-sm text-gray-700 dark:text-gray-300">
                                {{ \Illuminate\Support\Str::limit($contact->message, 90) }}
                            </p>

                            <div x-cloak x-show="open" x-transition.opacity class="mt-2 rounded-xl bg-gray-50/70 dark:bg-gray-900/40 p-3 text-sm text-gray-800 dark:text-gray-200">
                                {{ $contact->message }}
                            </div>

                            <footer class="mt-4 flex items-center gap-2">
                                <a href="mailto:{{ $contact->email }}?subject={{ urlencode('[Always Café] Reply to your message #'.$contact->id) }}"
                                   class="inline-flex items-center justify-center rounded-lg border border-green-300 dark:border-green-600
                                          px-3 py-2 text-xs font-medium text-green-700 dark:text-green-400
                                          hover:bg-green-600 dark:hover:bg-green-500 hover:text-white transition">
                                    Reply
                                </a>

                                <form action="{{ route('admin.contact.destroy', $contact->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                    @csrf @method('DELETE')
                                    <button type="submit"
                                            class="inline-flex items-center justify-center rounded-lg border border-red-300 dark:border-red-600
                                                   px-3 py-2 text-xs font-medium text-red-600 dark:text-red-400
                                                   hover:bg-red-600 dark:hover:bg-red-500 hover:text-white transition">
                                        Delete
                                    </button>
                                </form>
                            </footer>
                        </article>
                    @empty
                        <div class="px-2 py-10 text-center text-gray-400 dark:text-gray-500">
                            <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                      d="M8 9h8m-8 4h6m9 5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z" />
                            </svg>
                            <p class="text-lg font-medium">No contact messages found</p>
                            <p class="text-sm">Once users send messages, they will appear here.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ===================== Desktop Table (sm+) ===================== --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[960px] w-full text-left border-collapse">
                            <thead>
                                <tr class="sticky top-0 z-10 bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-800 dark:to-gray-700 border-b border-gray-300 dark:border-gray-700">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-24">ID</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[28%]">Name / Email</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider">Message</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-200 uppercase tracking-wider w-[22%]">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($contacts as $contact)
                                    <tr class="group hover:bg-gray-50/80 dark:hover:bg-gray-700/70 hover:shadow-md transition-all duration-300 ease-in-out" x-data="{open:false,copied:false}">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">#{{ $contact->id }}</td>

                                        <td class="px-6 py-4">
                                            <div class="font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                {{ \Illuminate\Support\Str::limit($contact->name, 56) }}
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <a href="mailto:{{ $contact->email }}?subject={{ urlencode('[Always Café] Reply to your message #'.$contact->id) }}"
                                                   class="text-sm text-blue-600 dark:text-blue-400 hover:underline truncate max-w-[300px]">
                                                    {{ \Illuminate\Support\Str::limit($contact->email, 44) }}
                                                </a>
                                                <button type="button"
                                                        @click="navigator.clipboard.writeText(@js($contact->email)); copied=true; setTimeout(()=>copied=false,1200)"
                                                        class="px-2 py-0.5 text-[11px] rounded-lg border border-gray-300 dark:border-gray-600
                                                               text-gray-700 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                                    Copy
                                                </button>
                                                <span class="text-[11px] text-green-600 dark:text-green-400" x-cloak x-show="copied" x-transition.opacity>Copied</span>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4 align-top">
                                            <p class="text-gray-700 dark:text-gray-300">
                                                {{ \Illuminate\Support\Str::limit($contact->message, 80) }}
                                            </p>
                                            <div x-cloak x-show="open" x-transition.opacity class="mt-2 rounded-xl bg-gray-50/70 dark:bg-gray-900/40 p-3 text-sm text-gray-800 dark:text-gray-200">
                                                {{ $contact->message }}
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center justify-center gap-2">
                                                <button type="button" @click="open=!open"
                                                        class="inline-flex items-center px-3 py-1.5 border border-gray-300 dark:border-gray-600
                                                               text-xs font-medium rounded-lg text-gray-700 dark:text-gray-300
                                                               hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                    </svg>
                                                    <span x-cloak x-show="!open">Preview</span>
                                                    <span x-cloak x-show="open">Hide</span>
                                                </button>

                                                <a href="mailto:{{ $contact->email }}?subject={{ urlencode('[Always Café] Reply to your message #'.$contact->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-green-300 dark:border-green-600 
                                                          text-xs font-medium rounded-lg text-green-700 dark:text-green-400 
                                                          hover:bg-green-600 dark:hover:bg-green-500 hover:text-white transition">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M16 12H8m0 0l4-4m-4 4l4 4" />
                                                    </svg>
                                                    Reply
                                                </a>

                                                <form action="{{ route('admin.contact.destroy', $contact->id) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('Are you sure you want to delete this contact?');">
                                                    @csrf @method('DELETE')
                                                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                                   text-xs font-medium rounded-lg text-red-600 dark:text-red-400 
                                                                   hover:bg-red-600 dark:hover:bg-red-500 hover:text-white 
                                                                   transition">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
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
                                        <td colspan="4" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 dark:text-gray-500">
                                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M8 9h8m-8 4h6m9 5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z" />
                                                </svg>
                                                <p class="text-lg font-medium">No contact messages found</p>
                                                <p class="text-sm">Once users send messages, they will appear here.</p>
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
                {{ $contacts->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
