<?php

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;

class ProfileController extends Controller
{

    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        if (Auth::check()) {
            return view('profile.edit', [
                'username' => $request->user()->username,
                'user' => $request->user(),
                'title' => 'Profile',
            ]);
        } else {
            return redirect()->route('login');
        }
    }

    /**
     * Update the user's profile information.
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255'],
                Rule::unique('admins', 'username', 'name')->ignore($request->user()->id)
                    ->where(function ($query) {
                        return $query->whereNull('deleted_at');
                    }),
            Rule::unique('ortus', 'username', 'name')->ignore($request->user()->id)
                ->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
            Rule::unique('users', 'username')->ignore($request->user()->id)
                ->where(function ($query) {
                    return $query->whereNull('deleted_at');
                }),
        ]);
        if ($request->user()->getTable() !== 'users') {
            $request->user()->fill([
                'name' => $request->name,
                'username' => $request->username,
            ]);
        } else {

            $request->user()->fill([
                'username' => $request->username,
            ]);
        }



        $request->user()->save();
        return Redirect::route('profile.edit')->with('success', 'Profile updated successfully');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();
        if ($user->getTable() === 'users') {
            return back()->with('error', 'hayo mau ngapain!!');
        }
        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}