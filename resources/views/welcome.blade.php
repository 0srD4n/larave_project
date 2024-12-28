<x-heade-home :title="$title">
    <body class="antialiased bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <x-navhome></x-navhome>
        <div class="min-h-screen">
            <!-- Hero Section -->
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-24 mt-16">
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                    <div class="space-y-8">
                        <h1 class="text-4xl md:text-5xl font-extrabold text-gray-900 dark:text-gray-100 leading-tight">
                            Lorem ipsum dolor sit amet.
                            <span class="bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                                Lorem, ipsum dolor.
                            </span>
                        </h1>
                        <p class="text-xl text-gray-600 dark:text-gray-300">
                            Lorem ipsum, dolor sit amet consectetur adipisicing elit. Assumenda obcaecati fuga illum incidunt, molestias expedita eum, aliquam doloribus ipsam libero in perferendis id eius at illo fugit voluptas sapiente est!
                        </p>
                        <div class="flex space-x-4">
                            <a href="{{ route('register') }}" class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-lg text-white bg-indigo-600 hover:bg-indigo-700 transition duration-150 ease-in-out">
                                Register
                                <svg class="ml-2 -mr-1 w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
                                </svg>
                            </a>
                            <a href="{{ route('login') }}" class="inline-flex items-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-lg text-gray-700 dark:text-gray-200 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 transition duration-150 ease-in-out">
                                Login
                            </a>
                        </div>
                    </div>
                    <div class="relative">
                        <div class="relative z-10 rounded-xl shadow-2xl overflow-hidden">
                            {{-- ambil image dari random link sadddddd dasad --}}
                            <img src="https://images.unsplash.com/photo-1522202176988-66273c2fd55f?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1471&q=80"
                                 alt="idk lol"
                                 class="w-full h-full object-cover">
                        </div>
                        <div class="absolute inset-0 bg-gradient-to-br from-indigo-600/20 to-purple-600/20 rounded-xl"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</x-heade-home>
