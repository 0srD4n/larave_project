<x-heade-home :title="$title">
    <x-navhome></x-navhome>
<body class="font-sans antialiased">
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-gray-50 to-gray-100 dark:from-gray-900 dark:to-gray-800">
        <div class="w-full sm:max-w-md mt-24 px-6 py-4 bg-white dark:bg-gray-800 shadow-lg rounded-lg">
            <div class="mb-6 text-center">
                <h2 class="text-2xl font-bold text-gray-900 dark:text-gray-100">
                    Buat Akun Baru
                </h2>
                <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                    Silakan isi informasi Anda untuk mendaftar
                </p>
            </div>
            @if ($errors->any())
            <div class="flex items-center p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
                <svg class="flex-shrink-0 inline w-4 h-4 me-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1v-3H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v4h1a1 1 0 0 1 0 2Z"/>
                </svg>
                <span class="sr-only">Error</span>
                <div>
                    @foreach ($errors->all() as $error)
                        <span class="font-medium">{{ $error }}</span>
                    @endforeach
                </div>
            </div>
            @endif
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <div>
                    <x-input-label for="name" :value="__('Nama Lengkap')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="name" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Masukkan nama lengkap" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Nama Siswa -->
                <div>
                    <x-input-label for="nis_anak" :value="__('NIS Siswa')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="nis_anak" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="number" name="nis_anak" :value="old('nis_anak')" required autocomplete="nis_anak" placeholder="Masukkan NIS siswa" />
                    <x-input-error :messages="$errors->get('nis')" class="mt-2" />
                </div>

                <!-- Nama Pengguna -->
                <div>
                    <x-input-label for="username" :value="__('Nama Pengguna')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="username" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="text" name="username" :value="old('username')" required autocomplete="username" placeholder="masukan nama pengguna menggunakan lowercase g" />
                    <x-input-error :messages="$errors->get('username')" class="mt-2" />
                </div>

                <!-- Kata Sandi -->
                <div>
                    <x-input-label for="password" :value="__('Kata Sandi')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <div class="relative">
                        <x-text-input id="password" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password" required autocomplete="new-password" placeholder="Buat kata sandi yang kuat" />
                    </div>
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Konfirmasi Kata Sandi -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Konfirmasi Kata Sandi')" class="text-sm font-medium text-gray-700 dark:text-gray-300" />
                    <x-text-input id="password_confirmation" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="Konfirmasi kata sandi Anda" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <div class="flex items-center justify-between mt-6">
                    <a class="text-sm text-indigo-600 hover:text-indigo-500 dark:text-indigo-400 dark:hover:text-indigo-300" href="{{ route('login') }}">
                        {{ __('Sudah punya akun?') }}
                    </a>

                    <x-primary-button class="ml-4 bg-indigo-600 hover:bg-indigo-700 focus:ring-indigo-500">
                        {{ __('Daftar') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</body>
</x-heade-home>
