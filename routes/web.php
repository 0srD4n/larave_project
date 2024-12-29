<?php

use Illuminate\Support\Facades\URL;
if(config('app.env') == 'production'){
    URL::forceScheme('https');
}

    use App\Http\Controllers\captcha;
    use Illuminate\Support\Facades\Auth;
    use Illuminate\Support\Facades\Route;
    use App\Http\Controllers\status\AdminController;
    use App\Http\Controllers\ProfileController;

// route dashboard
Route::middleware('auth:admin')->group(function () {
    Route::resource('admin', AdminController::class);
    Route::get('/dashboard/admin', function () {
        if (Auth::check() && Auth::user()->status < 3) {
            return view('dashboard.dashadmin', ['title' => 'Dashboard Admin']);
        }
        return redirect()->route('login');
    })->name('admin');
    // siswa import
    Route::post('/siswa/import', [AdminController::class, 'importUsers'])->name('import.siswa');
    // mencari terlamabat ddi dalam tabaese
    Route::get('/add', [AdminController::class, 'index'])->name('add');
    Route::get('/search-student', [AdminController::class, 'searchStudent'])->name('search.student');
    Route::post('/store-late', [AdminController::class, 'storeLate'])->name('late.store');
    Route::get('/control-panel', [AdminController::class, 'controlPanel'])->name('admin.control-panel');
    Route::post('/add}', [AdminController::class, 'destroy'])->name('late.destroy');
    // export database
    Route::post('/export-database', [AdminController::class, 'exportDatabase'])->name('admin.export');
    // truncate database
    Route::post('/truncate-database', [AdminController::class, 'truncateDatabase'])->name('admin.truncate');
    Route::post('/admin/import', [AdminController::class, 'importAdmin'])->name('admin.import');
    Route::get('/admin/export', [AdminController::class, 'exportDatabase'])->name('admin.export.admin');
    Route::get('/admin/show/{admin}', [AdminController::class, 'show'])->name('admin.show.admin');
    Route::get('/admin/edit/{admin}', [AdminController::class, 'edit'])->name('admin.edit.admin');
    Route::put('/admin/update/{admin}', [AdminController::class, 'update'])->name('admin.update.admin');
    Route::delete('/admin/destroy/{admin}', [AdminController::class, 'destroy'])->name('admin.destroy.admin');
    Route::get('/admin/list', [AdminController::class, 'list'])->name('admin.list');
    Route::delete('/sessions/{session}', [AdminController::class, 'destroySession'])->name('sessions.destroy');
});
Route::middleware('auth:ortu')->group(function () {
    Route::get('/dashboard/ortu', function () {
        return view('dashboard.dashortu', ['title' => 'Dashboard Orang Tua']);
    })->name('ortu');
});

Route::middleware('auth:web')->group(function () {
    Route::get('/dashboard/siswa', function () {
        return view('dashboard.dashsis', ['title' => 'Dashboard Siswa']);
    })->name('siswa');
});

Route::get('/', function () {
    if (Auth::check()) {
        if (Auth::user()->status > 3) {
            return redirect()->route('admin');
        } elseif (Auth::user()->status == 3 && Auth::user()->ortus) {
            return redirect()->route('ortu');
        } else {
            return redirect()->route('siswa');
        }
    }
    return view('welcome', ['title' => 'Home']);
});
// all users can accces sa
Route::middleware(['auth:web,admin,ortu'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/info', function () {
        return "ini info";
    })->name('info');
    Route::get('/chatroom', function () {
        return "ini chatroom";
    })->name('chatroom');
});
// melakukan generate captha untuk mengambil captcha nya
Route::get('/captcha', [captcha::class, 'generate'])->name('captcha.generate');
require __DIR__.'/auth.php';