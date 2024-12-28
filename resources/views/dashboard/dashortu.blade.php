<x-app-layout>
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

                    </div>
                </div>
            </div>
            {{-- identitas anakssssa --}}
            <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden">
                <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4">
                    <h3 class="text-xl font-bold text-white text-center">IDENTITAS ANAK</h3>
                </div>
                <div class="p-6">
                    @php
                        $anak = \App\Models\User::where('nis', Auth::user()->nis_anak)->first();
                    @endphp
                    @if($anak)
                        <div class="flex items-center mb-3">
                            <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center mr-6">
                                <svg class="w-16 h-20 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                            </div>
                            <div class="grid grid-cols-2 gap-4 ">

                            <div>
                                <div class="text-sm text-gray-500 dark:text-gray-400">Nama Siswa</div>
                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->name }}</div>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nomor Induk Siswa</div>
                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->nis }}</div>

                            </div>
                            <div>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Total Terlambat</div>
                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->keterlambatan ? $anak->keterlambatan->count() : 0 }}</div>
                                <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Kelas</div>
                                <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $anak->kelas }}</div>
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
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
                <div class="p-5">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-md bg-red-500 p-3">
                                <svg class="h-6 w-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </div>
                        </div>
                        <div class="ml-5 w-0 flex-1">
                            <dl>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">
                                    Total Terlambat
                                </dt>
                                <dd class="flex items-baseline">
                                    <div class="text-2xl font-semibold text-gray-900 dark:text-gray-100">
                                        {{ \App\Models\Keterlambatan::where('user_id', Auth::user()->id)->count() }}
                                    </div>
                                </dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 dark:bg-gray-700 px-5 py-3">
                    <div class="text-sm">
                        <div class="font-medium text-gray-700 dark:text-gray-200 mb-3">Riwayat Keterlambatan:</div>
                        @php
                            $keterlambatan = \App\Models\keterlambatan::where('user_id', Auth::user()->id)
                                ->orderBy('created_at', 'desc')
                                ->get();
                        @endphp
                        @if($keterlambatan->count() > 0)
                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                    <thead class="bg-gray-100 dark:bg-gray-800">
                                        <tr>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu</th>
                                            <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                        @foreach($keterlambatan as $index => $terlambat)
                                            <tr>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $index + 1 }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $terlambat->created_at->format('d M Y') }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-red-500">{{ $terlambat->created_at->format('H:i') }}</td>
                                                <td class="px-4 py-2 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300">{{ $terlambat->keterangan }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        @else
                            <div class="text-gray-500 dark:text-gray-400">Tidak ada riwayat keterlambatan</div>
                        @endif
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
