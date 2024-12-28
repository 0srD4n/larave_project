<?php

namespace App\Http\Controllers\Auth;

use session;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Http\Requests\Auth\LoginRequest;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login', ['title' => 'Login']);
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request)
    {
        $request->authenticate();
        $request->session()->regenerate();
        // Remove initial session call since we'll set it in the guard checks

        // Determine which guard was used for authentication
        if (Auth::guard('admin')->check()) {
            $user = Auth::guard('admin')->user();

            if ($user) {
                // Store keduanya agat muuncunl  session dab database
                session([
                    'username' => $user->username,
                    'user_type' => 'admin',
                    'ip_address' => $request->ip(),
                ]);

                // Update the database session record secara realtime tapi L:
                DB::table('sessions')
                    ->where('id', session()->getId())
                    ->updateOrInsert([
                        'id' => session()->getId()
                    ], [
                        'username' => $user->username,
                        'user_type' => $user->status,
                        'ip_address' => $request->ip(),
                        'last_activity' => now()->timestamp,
                        'payload' => serialize([])
                    ]);
            }

            return redirect()->route('admin');

        } elseif (Auth::guard('ortu')->check()) {
            $user = Auth::guard('ortu')->user();

            // Store in both session and database
            session([
                'username' => $user->username,
                'user_type' => 'ortu',
                'ip_address' => $request->ip(),
            ]);

            // Update the database session record
            DB::table('sessions')
                ->where('id', session()->getId())
                ->update([
                    'username' => $user->username,
                    'user_type' => 'ortu'
                ]);

            return redirect()->route('ortu');

        } elseif (Auth::guard('web')->check()) {
            $user = Auth::guard('web')->user();

            // Store in both session and database
            session([
                'username' => $user->username,
                'user_type' => 'user',
                'ip_address' => $request->ip(),
            ]);

            // Update the database session record
            DB::table('sessions')
                ->where('id', session()->getId())
                ->update([
                    'username' => $user->username,
                    'user_type' => 'user'
                ]);

            return redirect()->route('siswa');
        }

        // Fallback redirect if no guard is active (shouldn't happen)
        return redirect('/');
    }


    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        if (Auth::guard('admin')->check()) {
            Auth::guard('admin')->logout();
        } elseif (Auth::guard('ortu')->check()) {
            Auth::guard('ortu')->logout();
        } elseif (Auth::guard('web')->check()) {
            Auth::guard('web')->logout();
        }
        $request->session()->flush();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}