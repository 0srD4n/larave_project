<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Admin Panel') }}
        </h2>
    </x-slot>

    <div class="max-w-7xl pt-10 mx-auto sm:px-6 lg:px-8">
        @if(session('success'))
            <x-danger-button message="{{ session('success') }}" type="success"/>
        @elseif(session('error'))
            <x-danger-button message="{{ session('error') }}" type="error"/>
        @endif
        <div class="bg-white dark:bg-gray-800 shadow-lg rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700">
            <div class="p-8 text-gray-900 dark:text-gray-100">
                <!-- Search Form  tailwin seearch engin nig bos-->
                <div class="mb-8">
                    <label for="nis" class="block text-sm font-medium text-gray-700 dark:text-gray-300">NIS Siswa</label>
                    <form action="{{ route('search.student') }}" method="GET" class="flex gap-4">
                        <div class="flex-1">
                            <input type="text" name="nis" id="nis" placeholder="Masukkan NIS Siswa"
                                class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:text-gray-100 transition duration-150 ease-in-out"
                                value="{{ request('nis') }}">
                        </div>
                        <button type="submit" class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400">
                            <span class="flex items-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                                </svg>
                                Cari Siswa
                            </span>
                        </button>
                    </form>
                </div>

                @if(isset($student))
                    <!-- Info siswa -->
                    <div class="bg-white dark:bg-gray-800 shadow-lg rounded-lg overflow-hidden w-full max-w-3xl mx-auto">
                        <div class="bg-gradient-to-r from-blue-500 to-purple-600 p-4">
                            <h3 class="text-xl font-bold text-white text-center">Data Siswa</h3>
                        </div>
                        <div class="p-6">
                            <div class="flex items-center mb-3">
                                <div class="w-24 h-24 bg-gray-300 rounded-full flex items-center justify-center mr-6">
                                    <svg class="w-16 h-16 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="grid grid-cols-3 gap-7 ">
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Nama Siswa</div>
                                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $student->name }}</div>
                                            <div class="mt-2 text-sm text-gray-500 dark:text-gray-400">Nomor Induk Siswa</div>
                                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $student->nis }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Kelas</div>
                                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $student->kelas }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Nama Orang Tua</div>
                                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $student->nama_ortu }}</div>
                                        </div>
                                        <div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Total Terlambat</div>
                                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $lateRecords->count() }}</div>
                                            <div class="text-sm text-gray-500 dark:text-gray-400">Alamat</div>
                                            <div class="text-lg font-bold text-gray-900 dark:text-gray-100">{{ $student->alamat }}</div>
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
                        </div>
                    </div>
                      <!-- table untuk menambah keterlambatan form hhati hati males otak atikl \-->
                      <div class="mt-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100">Tambah Keterlambatan</h3>
                        <form action="{{ route('late.store') }}" method="POST" class="space-y-6">
                            @csrf
                            <input type="hidden" name="user_id" value="{{ $student->id }}">
                            <div class="space-y-2">
                                <label for="waktu_keterlambatan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Waktu Keterlambatan</label>
                                <input type="time" name="waktu_keterlambatan" id="waktu_keterlambatan" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:text-gray-100"
                                    value="{{ date('H:i') }}">
                            </div>

                            <div class="space-y-2">
                                <label for="keterangan" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Keterangan Keterlambatan</label>
                                <textarea name="keterangan" id="keterangan" rows="3" required
                                    class="w-full rounded-lg border-gray-300 dark:border-gray-600 dark:bg-gray-700 shadow-sm focus:border-indigo-500 focus:ring-2 focus:ring-indigo-500 dark:focus:ring-indigo-400 dark:text-gray-100 resize-none"></textarea>
                            </div>

                            <div>
                                <button type="submit"
                                    class="w-full sm:w-auto px-6 py-2.5 bg-green-600 hover:bg-green-700 text-white font-medium rounded-lg shadow-md hover:shadow-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-green-500 dark:focus:ring-green-400">
                                    <span class="flex items-center justify-center gap-2">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                        </svg>
                                        Simpan Keterlambatan
                                    </span>
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="mb-8">
                        <h3 class="text-xl font-bold mb-4 text-gray-900 dark:text-gray-100 text-center">Riwayat Terlambat</h3>
                        <div class="overflow-x-auto rounded-xl border border-gray-200 dark:border-gray-700">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700/50">
                                    <tr>
                                        <th class="w-1/6 px-2 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">No</th>
                                        <th class="w-1/6 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Tanggal</th>
                                        <th class="w-1/6 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Waktu Terlambat</th>
                                        <th class="w-2/6 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Keterangan</th>
                                        <th class="w-1/6 px-6 py-3 text-center text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody id="lateRecordsTable" class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @forelse($lateRecords->take(5) as $record)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 text-center">{{ $loop->iteration }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 text-center">{{ \Carbon\Carbon::parse($record->waktu_keterlambatan)->format('Y-m-d') }}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 text-center">{{ \Carbon\Carbon::parse($record->waktu_keterlambatan)->format('H:i') }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 text-center">{{ $record->keterangan }}</td>
                                            <td class="px-6 py-4 text-sm text-center">
                                                <form action="{{ route('late.destroy', $record->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500 dark:text-gray-400">
                                                Tidak ada data keterlambatan
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        @if(isset($lateRecords) && $lateRecords->count() > 5)
                        <div class="mt-4 flex justify-center gap-2">
                            <button id="prevBtn" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg disabled:opacity-50" disabled>
                                Previous
                            </button>
                            <button id="nextBtn" class="px-4 py-2 bg-gray-200 dark:bg-gray-700 text-gray-700 dark:text-gray-200 rounded-lg">
                                Next
                            </button>
                        </div>

                        <script>
                            const records = @json($lateRecords);
                            let currentPage = 0;
                            const recordsPerPage = 5;
                            const totalPages = Math.ceil(records.length / recordsPerPage);

                            function updateTable(page) {
                                const start = page * recordsPerPage;
                                const end = start + recordsPerPage;
                                const pageRecords = records.slice(start, end);

                                const tbody = document.getElementById('lateRecordsTable');
                                tbody.innerHTML = '';

                                pageRecords.forEach((record, index) => {
                                    const row = `
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700/50 transition duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 text-center">${start + index + 1}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 text-center">${new Date(record.waktu_keterlambatan).toLocaleDateString()}</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 dark:text-gray-300 text-center">${new Date(record.waktu_keterlambatan).toLocaleTimeString([], {hour: '2-digit', minute:'2-digit'})}</td>
                                            <td class="px-6 py-4 text-sm text-gray-600 dark:text-gray-300 text-center">${record.keterangan}</td>
                                            <td class="px-6 py-4 text-sm text-center">
                                                <form action="/late/${record.id}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="text-red-600 hover:text-red-900 dark:text-red-400 dark:hover:text-red-300">
                                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    `;
                                    tbody.innerHTML += row;
                                });

                                document.getElementById('prevBtn').disabled = page === 0;
                                document.getElementById('nextBtn').disabled = page === totalPages - 1;
                            }

                            document.getElementById('prevBtn').addEventListener('click', () => {
                                if (currentPage > 0) {
                                    currentPage--;
                                    updateTable(currentPage);
                                }
                            });

                            document.getElementById('nextBtn').addEventListener('click', () => {
                                if (currentPage < totalPages - 1) {
                                    currentPage++;
                                    updateTable(currentPage);
                                }
                            });
                        </script>
                        @endif
                    </div>

                @else
                    @if(request('nis'))
                        <div class="flex items-center justify-center p-8">
                            <div class="bg-red-50 dark:bg-red-900/30 text-red-600 dark:text-red-300 px-6 py-4 rounded-lg border border-red-200 dark:border-red-800">
                                <p class="flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Siswa dengan {{ request('nis') }}  tidak  ditemukan nnob
                                </p>
                            </div>
                        </div>
                    @endif
                @endif

            </div>
        </div>
    </div>
</x-app-layout>
