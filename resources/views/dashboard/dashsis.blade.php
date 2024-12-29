<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight" style="text-align: center">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Card -->
            <div class="bg-gradient-to-r from-purple-500 to-indigo-600 rounded-lg shadow-xl p-6 mb-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-12 w-12 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                    </div>
                    <div class="ml-5">
                        <h3 class="text-lg leading-6 font-medium text-white">
                            Welcome back, {{ Auth::user()->name }}!
                        </h3>
                        <p class="mt-1 text-sm font-bold">
                          Your role is <span style="color:white">{{ Auth::user()->status == '1' ? 'Admin' : (Auth::user()->status == '2' ? 'Guru' : (Auth::user()->status == '3' ? 'Siswa' : (Auth::user()->status == '4' ? 'Ortu' : ''))) }}</span>
                        </p>

                    </div>
                </div>
            </div>
            {{--identitas ssisswa --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4">
                    <h3 class="text-xl font-bold text-white text-center">IDENTITAS</h3>
                </div>
                <div class="p-6">
                    @php
                        $anak = \App\Models\User::where('nis', Auth::user()->nis)->first();
                        $ortu = \App\Models\Ortu::where('nis_anak', Auth::user()->nis)->first();
                        $late = \App\Models\Keterlambatan::where('user_id', Auth::user()->id)->get();
                    @endphp
                    @if($anak)
                        <div class="flex items-center mb-3">
                            <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center mr-6">
                                <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div>
                                <div class="grid grid-cols-3 gap-4 ">
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Nama Siswa</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->name }}</div>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nomor Induk Siswa</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->nis }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Kelas</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->kelas }}</div>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Orang Tua</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $ortu->name ?? '' }}</div>
                                    </div>
                                    <div>
                                        <div class="text-sm text-gray-500 dark:text-gray-400">Total Terlambat</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $late->count() ?? 0 }}</div>
                                        <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Alamat</div>
                                        <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->alamat ?? '' }}</div>
                                    </div>

                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200 dark:border-gray-700 pt-4">
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Status</div>
                                    <div class="text-md font-semibold text-gray-900 dark:text-gray-100">Aktif</div>
                                </div>
                                <div>
                                    <div class="text-sm text-gray-500 dark:text-gray-400">Tahun Ajaran</div>
                                    <div class="text-md font-semibold text-gray-900 dark:text-gray-100">{{ env('TAHUN_AJARAN') }}</div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="text-xl font-semibold text-red-500">Data anak tidak ditemukan</div>
                        </div>
                    @endif
                </div>
            </div>
            <br>
            <br>
            <!-- Stats Grid -->
            <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-2 mb-6">
                <!-- Stat Card 1 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-md bg-indigo-500 p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Siswa
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                            {{ \App\Models\User::where('status', '3')->count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                    <div class="p-5">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="rounded-md bg-indigo-500 p-3">
                                    <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                        Total Guru
                                    </dt>
                                    <dd class="flex items-baseline">
                                        <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                            {{ \App\Models\Admin::where('status', '2')->count() }}
                                        </div>
                                    </dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
