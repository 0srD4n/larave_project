<x-app-layout :title="$title">
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Control Panel') }}
        </h2>
    </x-slot>
<div class="container mx-auto px-4 py-10 bg-gray-900">
    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <!-- Import Siswa Section -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-white">Import Siswa</h2>
            <form action="{{ route('import.siswa') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-300">Excel File</label>
                    <input type="file" name="excel_file" accept=".xlsx,.xls,.csv"
                           class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Import Siswa
                </button>
            </form>
        </div>

        <!-- Import Admin/Guru Section -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-white">Import Admin/Guru</h2>
            <form action="{{ route('admin.import') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                @csrf
                <div class="flex flex-col">
                    <label class="text-sm font-medium text-gray-300">Excel File</label>
                    <input type="file" name="excel_file" accept=".xlsx,.xls,.csv"
                           class="mt-1 block w-full px-3 py-2 bg-gray-700 border border-gray-600 rounded-md shadow-sm text-white focus:outline-none focus:ring-indigo-500 focus:border-indigo-500">
                </div>
                <button type="submit" class="w-full bg-indigo-600 text-white px-4 py-2 rounded-md hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    Import Admin/Guru
                </button>
            </form>
        </div>

        <!-- Manage Admins Section -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-white">Manage Admins</h2>
            <div class="space-y-4">
                <button onclick="window.location.href='{{ route('admin.create') }}'"
                        class="w-full bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700">
                    Add New Admin
                </button>
                <button onclick="window.location.href='{{ route('admin.list') }}'"
                        class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700">
                    View/Edit Admins
                </button>
            </div>
        </div>

        <!-- Database Management -->
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-white">Database Management</h2>
            <div class="space-y-4">
                <form action="{{ route('admin.export') }}" method="GET" class="inline">
                    <button type="submit" onclick="return confirm('Are you sure you want to export all database tables? This will download a zip file containing Excel files for each table.')"
                            class="w-full bg-yellow-600 text-white px-4 py-2 rounded-md hover:bg-yellow-700 mb-4">
                        Export Database Tables
                    </button>
                </form>

                <form action="{{ route('admin.truncate') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" onclick="return confirm('Warning: This action will delete all records from all tables. This cannot be undone! Are you absolutely sure?')"
                            class="w-full bg-red-600 text-white px-4 py-2 rounded-md hover:bg-red-700">
                        Clear All Data
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Active Sessions -->
    <div class="mt-8">
        <div class="bg-gray-800 p-6 rounded-lg shadow-lg">
            <h2 class="text-xl font-semibold mb-4 text-white">Active Sessions</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-700">
                    <thead class="bg-gray-700">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">Username</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">status</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-300 uppercase tracking-wider">action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach (DB::table('sessions')->get() as $session)
                        <tr>
                            @if ($session->username != null)

                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $session->username }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">{{ $session->user_type == '2' ? 'Guru' : 'Siswa/Orangtua' }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-gray-300">
                                <form action="{{ route('sessions.destroy', $session->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded-md text-sm">Logout</button>
                                </form>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</x-app-layout>

