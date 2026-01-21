<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center max-w-7xl mx-auto sm:px-6 lg:px-8 bg-white/80 dark:bg-gray-800/80 backdrop-blur-md rounded-xl px-4 py-4">
            <h2 class="font-semibold text-2xl text-gray-900 dark:text-gray-100 leading-tight mx-auto">
                Add New User
            </h2>
        </div>
    </x-slot>

    <div class="max-w-3xl mx-auto py-12 px-6">
        @if (session('success'))
            <x-notification type="success" :message="session('success')" />
        @endif

        @if ($errors->any())
            @foreach ($errors->all() as $error)
                <x-notification type="error" :message="$error" />
            @endforeach
        @endif

        <!-- Main Card -->
        <div
            class="rounded-2xl shadow-2xl border border-gray-200 dark:border-gray-700 
                    bg-white/80 dark:bg-gray-800/80 backdrop-blur-md 
                    transition-all duration-500 ease-in-out p-8">
            <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-6">
                User Information
            </h3>

            <form action="{{ route('admin.user.store') }}" method="POST" class="space-y-6">
                @csrf

                <!-- Full Name -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Full Name
                    </label>
                    <input type="text" name="name" value="{{ old('name') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                  bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                  focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                        placeholder="Enter full name">
                </div>

                <!-- Email -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Email Address
                    </label>
                    <input type="email" name="email" value="{{ old('email') }}"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                  bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                  focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                        placeholder="Enter email address">
                </div>

                <!-- Password -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Password
                        </label>
                        <input type="password" name="password"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                      bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                      focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                            placeholder="Enter password">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                            Confirm Password
                        </label>
                        <input type="password" name="password_confirmation"
                            class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                      bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                      focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300"
                            placeholder="Re-enter password">
                    </div>
                </div>

                <!-- Role -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">
                        Role
                    </label>
                    <select name="role"
                        class="w-full px-4 py-3 rounded-xl border border-gray-300 dark:border-gray-600 
                                   bg-gray-50 dark:bg-gray-700 text-gray-900 dark:text-gray-100
                                   focus:border-transparent focus:ring-2 focus:ring-blue-500 focus:outline-none transition-all duration-300">
                        <option value="">-- Select Role --</option>
                        <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                        <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                    </select>
                </div>

                <!-- Actions -->
                <div class="flex justify-end space-x-4 pt-6">
                    <a href="{{ route('admin.user.index') }}"
                        class="px-5 py-2 rounded-xl text-sm font-medium text-gray-600 dark:text-gray-300 
                              hover:text-gray-900 dark:hover:text-white transition duration-300">
                        Cancel
                    </a>
                    <button type="submit"  x-data="loadingButton" @click="handleClick" data-loading
                        class="px-6 py-2.5 rounded-xl bg-gradient-to-r from-gray-900 to-gray-800 
                                   dark:from-gray-100 dark:to-gray-300 
                                   text-white dark:text-gray-900 font-semibold text-sm 
                                   shadow-md hover:shadow-lg hover:scale-[1.02] 
                                   transition-all duration-300 ease-in-out">
                        Save User
                    </button>
                </div>
            </form>
        </div>
    </div>
</x-app-layout>
