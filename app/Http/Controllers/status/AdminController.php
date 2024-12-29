<?php

namespace App\Http\Controllers\status;

use ZipArchive;
use App\Models\User;
use App\Models\Admin;
use App\Exports\UsersExport;
use App\Imports\UsersImport;
use Illuminate\Http\Request;
use App\Exports\AdminsExport;
use App\Imports\AdminsImport;
use App\Models\Keterlambatan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Exports\KeterlambatanExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->status <= 2) {
            return view('admin.addfunc', [
                'title' => 'ADD',
            ]);
        }
        return redirect()->back()->with('error', 'You are not authorized to access this page');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only super administrators can manage admins');
        }
        return view('admin.create', [
            'title' => 'ADD',
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only super administrators can manage admins');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admins',
            'username' => 'required|string|max:255|unique:admins',
            'password' => 'required|string|min:8',
            'status' => 'required|in:1,2'
        ]);

        Admin::create([
            'name' => $validated['name'],
            'username' => $validated['username'],
            'password' => Hash::make($validated['password']),
            'status' => $validated['status']
        ]);

        return redirect()->route('admin.list')->with('success', 'Admin created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(Admin $admin)
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only super administrators can view admin details');
        }
        return view('admin.show', [
            'title' => 'ADD',
            'admin' => $admin
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Admin $admin)
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only super administrators can edit admins');
        }
        return view('admin.edit', [
            'title' => 'ADD',
            'admin' => $admin
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Admin $admin)
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only super administrators can update admins');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:admins,name,' . $admin->id,
            'username' => 'required|string|max:255|unique:admins,username,' . $admin->id,
            'password' => 'nullable|string|min:8',
            'status' => 'required|in:1,2'
        ]);

        $admin->name = $validated['name'];
        $admin->username = $validated['username'];
        if (!empty($validated['password'])) {
            $admin->password = Hash::make($validated['password']);
        }
        $admin->status = $validated['status'];
        $admin->save();

        return redirect()->route('admin.list')->with('success', 'Admin updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        if (Auth::user()->status <= 2) {
            $lateRecord = Keterlambatan::findOrFail($id);
            $lateRecord->delete();
            return redirect()->back()->with('success', 'Late record deleted successfully');
        }
        return redirect()->back()->with('error', 'You are not authorized to access this page');
    }

    /**
     * Search for student by NIS
     */
    public function searchStudent(Request $request)
    {
        if (Auth::user()->status <= 2) {
            $student = User::where('nis', $request->nis)->first();

            if ($student) {
                $lateRecords = Keterlambatan::where('user_id', $student->id)->get();
                return view('admin.addfunc', [
                    'title' => 'Search',
                    'student' => $student,
                    'lateRecords' => $lateRecords
                ]);
            }

            return view('admin.addfunc')->with('error', 'Student not found');
        }
        return redirect()->back()->with('error', 'You are not authorized to access this page');
    }

    /**
     * Store late record for student
     */
    public function storeLate(Request $request)
    {
        if (Auth::user()->status <= 2) {
            $validated = $request->validate([
                'user_id' => 'required|exists:users,id',
                'keterangan' => 'required|string',
                'waktu_keterlambatan' => 'nullable',
            ]);

            Keterlambatan::create($validated);
            return redirect()->back()->with('success', 'Late record added successfully');
        }
        return redirect()->back()->with('error', 'You are not authorized to access this page');
    }

    /**
     * Display control panel
     */
    public function controlPanel()
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only administrators can access the control panel');
        }
        return view('admin.controlppaneladmin', [
            'title' => 'Control Panel',
        ]);
    }
    public function destroySession($id)
    {
        DB::table('sessions')->where('id', $id)->delete();
        return redirect()->back()->with('success', 'Session deleted successfully');
    }
    /**
     * Import admin data
     */
    public function importAdmin(Request $request)
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only administrators can import users');
        }

        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new AdminsImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Admins imported successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing admins: ' . $e->getMessage());
        }
    }

    /**
     * Import student data
     */
    public function importUsers(Request $request)
    {
        Log::info('Export database method called.');

        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only administrators can import users');
        }

        $request->validate([
            'excel_file' => 'required|mimes:xlsx,xls,csv'
        ]);

        try {
            Excel::import(new UsersImport, $request->file('excel_file'));
            return redirect()->back()->with('success', 'Users imported successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error importing users: ' . $e->getMessage());
        }
    }

    /**
     * Export all database tables
     */
    public function exportDatabase()
    {
        try {
            $timestamp = now()->format('Y-m-d_H-i-s');

            $zip = new ZipArchive();
            $zipName = 'database_export_' . $timestamp . '.zip';
            $zipPath = storage_path('app/public/' . $zipName);
            $zip->open($zipPath, ZipArchive::CREATE);

            $usersPath = 'users_' . $timestamp . '.xlsx';
            Excel::store(new UsersExport(), $usersPath, 'public');
            $zip->addFile(storage_path('app/public/' . $usersPath), $usersPath);

            $adminsPath = 'admins_' . $timestamp . '.xlsx';
            Excel::store(new AdminsExport(), $adminsPath, 'public');
            $zip->addFile(storage_path('app/public/' . $adminsPath), $adminsPath);

            $keterlambatanPath = 'keterlambatan_' . $timestamp . '.xlsx';
            Excel::store(new KeterlambatanExport(), $keterlambatanPath, 'public');
            $zip->addFile(storage_path('app/public/' . $keterlambatanPath), $keterlambatanPath);
            $zip->close();

            Storage::disk('public')->delete([$usersPath, $adminsPath, $keterlambatanPath]);

            return response()->download($zipPath)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error exporting database: ' . $e->getMessage());
        }
    }

    /**
     * Clear all database tables
     */
    public function truncateDatabase()
    {
        if (Auth::user()->status != 1) {
            return redirect()->back()->with('error', 'Only administrators can clear database');
        }

        try {
            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            DB::table('users')->truncate();
            DB::table('admins')->truncate();
            DB::table('sessions')->truncate();
            DB::table('keterlambatan_siswa')->truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');

            return redirect()->back()->with('success', 'Database cleared successfully');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Error clearing database: ' . $e->getMessage());
        }
    }
}