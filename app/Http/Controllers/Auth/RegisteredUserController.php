<?php

namespace App\Http\Controllers\Auth;

use App\Models\Ortu;
use App\Models\User;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rules;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Auth\Events\Registered;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register',[
            'title' => 'Register',
        ]);
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', 'unique:'.Ortu::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nis_anak' => ['required', 'string', 'max:255'],
        ]);

        // Check if nis_anak exists in the users table
        $user = User::where('nis', $request->nis_anak)->first();

        if (!$user) {
            return redirect()->back()->withErrors(['nis_anak' => 'NIS not found in users table.']);
        }

        $ortu = Ortu::create([
            'name' => $request->name,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'nis_anak' => $user->nis,
        ]);

        event(new Registered($ortu));

        Auth::guard('ortu')->login($ortu);

        return redirect(route('ortu', absolute: false));
    }
}