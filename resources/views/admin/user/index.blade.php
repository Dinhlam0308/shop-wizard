<x-app-layout>
    <x-slot name="header">
        <div
            class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <x-back-to-dashboard class="mr-3" />
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight">
                {{ __('User') }}
            </h2>
            <a href="{{ route('admin.user.create') }}"
               class="inline-flex items-center px-5 py-2.5 border-2 border-gray-300 dark:border-gray-600 
                      text-sm font-semibold rounded-xl 
                      text-gray-700 dark:text-gray-200 
                      bg-transparent hover:bg-gray-800 dark:hover:bg-gray-700 
                      hover:text-white hover:border-gray-800 dark:hover:border-gray-500
                      focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-300 ease-in-out">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                </svg>
                Create
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800 transition-colors duration-500">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Notifications --}}
            @if (session('success'))
                <x-notification type="success" :message="session('success')" />
            @endif

            <div
                class="bg-white/80 dark:bg-gray-800/80 shadow-2xl rounded-2xl overflow-hidden border border-gray-200 dark:border-gray-700 backdrop-blur-md transition-all duration-300 ease-in-out">

                {{-- ===================== Search (giữ nguyên) ===================== --}}
                <div class="mx-4 my-4 flex flex-wrap items-center justify-between gap-4">
                    <form method="GET" action="{{ route('admin.user.index') }}" class="flex items-center gap-3">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Search by User ID..."
                            class="px-4 py-2.5 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-white/80 dark:bg-gray-800/80 text-gray-900 dark:text-gray-100
                                   placeholder-gray-400 dark:placeholder-gray-500
                                   focus:ring-2 focus:ring-gray-600 focus:outline-none transition-all w-64" />
                        <button type="submit"
                            class="px-4 py-2 rounded-xl text-sm font-semibold text-white bg-gray-900 dark:bg-gray-200 
                                   dark:text-gray-900 hover:scale-[1.03] transition-all duration-300">
                            Search
                        </button>
                    </form>

                    @if (request('search'))
                        <a href="{{ route('admin.user.index') }}"
                           class="text-sm text-gray-500 dark:text-gray-400 hover:text-gray-800 dark:hover:text-gray-200 transition">
                            ✕ Clear Search
                        </a>
                    @endif
                </div>

                {{-- ===================== Mobile Cards (<sm) ===================== --}}
                <div class="sm:hidden px-4 pb-4">
                    @forelse($users as $user)
                        <article
                            class="mb-3 rounded-2xl border border-gray-200 dark:border-gray-700 bg-white/80 dark:bg-gray-800/80
                                   p-4 shadow-sm hover:shadow-md transition"
                            x-data="{
                                email: @js($user->email),
                                copied:false,
                                copy(){ navigator.clipboard.writeText(this.email); this.copied=true; setTimeout(()=>this.copied=false,1200); }
                            }">
                            <header class="flex items-start gap-3">
                                {{-- Avatar fallback --}}
                                @php
                                    $initial = strtoupper(mb_substr($user->name ?? 'U', 0, 1, 'UTF-8'));
                                @endphp
                                <div class="shrink-0 w-10 h-10 rounded-xl bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 grid place-items-center text-sm font-semibold text-gray-700 dark:text-gray-200">
                                    {{ $initial }}
                                </div>

                                <div class="min-w-0 flex-1">
                                    <h3 class="text-base font-semibold text-gray-900 dark:text-gray-100 truncate">
                                        #{{ $user->id }} · {{ \Illuminate\Support\Str::limit($user->name, 56) }}
                                    </h3>
                                    <div class="mt-1 flex items-center gap-2">
                                        <span class="text-sm text-gray-600 dark:text-gray-300 truncate max-w-[220px]">
                                            {{ $user->email }}
                                        </span>
                                        <button type="button" @click="copy()"
                                                class="px-2 py-0.5 text-[11px] rounded border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                            Copy
                                        </button>
                                        <span class="text-[11px] text-green-600 dark:text-green-400" x-cloak x-show="copied" x-transition.opacity>Copied</span>
                                    </div>

                                    @php
                                        $role = strtolower($user->role ?? 'user');
                                        $roleMap = [
                                            'admin'   => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'staff'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'editor'  => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
                                            'manager' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            'user'    => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                        ];
                                        $roleClass = $roleMap[$role] ?? $roleMap['user'];
                                    @endphp
                                    <div class="mt-2">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-[11px] font-medium {{ $roleClass }}">
                                            {{ ucfirst($user->role) }}
                                        </span>
                                    </div>
                                </div>
                            </header>

                            <footer class="mt-4 flex items-center gap-2">
                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                   class="inline-flex items-center justify-center rounded-lg border border-blue-300 dark:border-blue-600
                                          px-3 py-2 text-xs font-medium text-blue-600 dark:text-blue-400
                                          hover:bg-blue-600 dark:hover:bg-blue-500 hover:text-white transition">
                                    Edit
                                </a>
                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
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
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 9h8m-8 4h6m9 5V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2h14a2 2 0 002-2z" />
                            </svg>
                            <p class="text-lg font-medium">No users found</p>
                            <p class="text-sm">Start by adding your first user.</p>
                        </div>
                    @endforelse
                </div>

                {{-- ===================== Desktop Table (sm+) ===================== --}}
                <div class="hidden sm:block">
                    <div class="overflow-x-auto">
                        <table class="min-w-[980px] w-full text-left border-collapse">
                            <thead>
                                <tr
                                    class="sticky top-0 z-10 bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 border-b border-gray-200 dark:border-gray-700">
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider w-20">ID</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider w-[28%]">Name</th>
                                    <th class="px-6 py-4 text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider w-32">Role</th>
                                    <th class="px-6 py-4 text-center text-xs font-semibold text-gray-700 dark:text-gray-300 uppercase tracking-wider w-[18%]">Actions</th>
                                </tr>
                            </thead>

                            <tbody class="divide-y divide-gray-200 dark:divide-gray-700">
                                @forelse($users as $user)
                                    @php
                                        $role = strtolower($user->role ?? 'user');
                                        $roleMap = [
                                            'admin'   => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200',
                                            'staff'   => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200',
                                            'editor'  => 'bg-amber-100 text-amber-800 dark:bg-amber-900 dark:text-amber-200',
                                            'manager' => 'bg-purple-100 text-purple-800 dark:bg-purple-900 dark:text-purple-200',
                                            'user'    => 'bg-gray-100 text-gray-700 dark:bg-gray-700 dark:text-gray-300',
                                        ];
                                        $roleClass = $roleMap[$role] ?? $roleMap['user'];
                                    @endphp
                                    <tr class="group hover:bg-gray-50 dark:hover:bg-gray-700 hover:shadow-md transition-all duration-300 ease-in-out">
                                        <td class="px-6 py-4 text-sm font-medium text-gray-900 dark:text-gray-100 whitespace-nowrap">
                                            #{{ $user->id }}
                                        </td>

                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-3 min-w-0">
                                                {{-- Avatar fallback --}}
                                                @php
                                                    $initial = strtoupper(mb_substr($user->name ?? 'U', 0, 1, 'UTF-8'));
                                                @endphp
                                                <div class="w-9 h-9 rounded-lg bg-gradient-to-br from-gray-200 to-gray-300 dark:from-gray-700 dark:to-gray-600 grid place-items-center text-xs font-semibold text-gray-700 dark:text-gray-200">
                                                    {{ $initial }}
                                                </div>
                                                <div class="min-w-0">
                                                    <div class="font-semibold text-gray-900 dark:text-gray-100 truncate">
                                                        {{ \Illuminate\Support\Str::limit($user->name, 60) }}
                                                    </div>
                                                    <div class="text-xs text-gray-500 dark:text-gray-400 truncate max-w-[360px]"
                                                         x-data="{ email:@js($user->email), copied:false, copy(){ navigator.clipboard.writeText(this.email); this.copied=true; setTimeout(()=>this.copied=false,1200);} }">
                                                        <span>{{ $user->email }}</span>
                                                        <button type="button" @click="copy()"
                                                                class="ml-2 px-2 py-0.5 text-[11px] rounded border border-gray-300 dark:border-gray-600 text-gray-600 dark:text-gray-300 hover:bg-gray-800 dark:hover:bg-gray-700 hover:text-white transition">
                                                            Copy
                                                        </button>
                                                        <span class="ml-1 text-[11px] text-green-600 dark:text-green-400" x-cloak x-show="copied" x-transition.opacity>Copied</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>

                                        <td class="px-6 py-4">
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $roleClass }}">
                                                {{ ucfirst($user->role) }}
                                            </span>
                                        </td>

                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="{{ route('admin.user.edit', $user->id) }}"
                                                   class="inline-flex items-center px-3 py-1.5 border border-blue-300 dark:border-blue-600 
                                                          text-xs font-medium rounded-lg 
                                                          text-blue-600 dark:text-blue-400 
                                                          bg-transparent hover:bg-blue-600 dark:hover:bg-blue-500 
                                                          hover:text-white hover:border-blue-600 dark:hover:border-blue-400
                                                          focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-300 ease-in-out">
                                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                              d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                    </svg>
                                                    Edit
                                                </a>
                                                <form action="{{ route('admin.user.destroy', $user->id) }}" method="POST"
                                                      class="inline-block"
                                                      onsubmit="return confirm('Are you sure you want to delete this user?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" x-data="loadingButton" @click="handleClick" data-loading
                                                            class="inline-flex items-center px-3 py-1.5 border border-red-300 dark:border-red-600 
                                                                   text-xs font-medium rounded-lg 
                                                                   text-red-600 dark:text-red-400 
                                                                   bg-transparent hover:bg-red-600 dark:hover:bg-red-500 
                                                                   hover:text-white hover:border-red-600 dark:hover:border-red-400
                                                                   focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500 transition-all duration-300 ease-in-out">
                                                        <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                                  d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862
                                                                     a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6
                                                                     m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-12 text-center">
                                            <div class="text-gray-400 dark:text-gray-500">
                                                <svg class="mx-auto h-12 w-12 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2 2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" />
                                                </svg>
                                                <p class="text-lg font-medium">No users found</p>
                                                <p class="text-sm">Start by adding your first user.</p>
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
                {{ $users->links() }}
            </div>
        </div>
    </div>
</x-app-layout>
