<nav class="bg-gray-100 dark:bg-gray-900 dark:border-gray-600 fixed w-full top-0 z-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex items-center">
                <a href="/" class="text-2xl font-bold text-gray-800 dark:text-gray-200">
                    {{ config('app.name', 'Laravel') }}
                </a>
            </div>
            <div class="flex items-center space-x-4">
                <a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }} px-4 py-2 rounded-md text-sm font-medium transition duration-150 ease-in-out">
                    Register
                </a>
                <a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'bg-indigo-600 text-white' : 'text-gray-500 dark:text-gray-400 hover:text-gray-700 dark:hover:text-gray-300' }} px-3 py-2 rounded-md text-sm font-medium">
                    Login
                </a>
            </div>
        </div>
    </div>
</nav>