<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            // 'captcha' => ['required'],
        ];
    }

    /**
     * Attempt to authenticate the request's credentials.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function authenticate(): void
    {
        $this->ensureIsNotRateLimited();

        // if ($this->input('captcha') !== Session::get('captcha_text')) {
        //     throw ValidationException::withMessages([
        //         'captcha' => 'CAPTCHA tidak valid.',
        //     ]);
        // }

        // Try authenticating against each guard/provider
        $credentials = $this->only('username', 'password');
        $remember = $this->boolean('remember');

        // Try admin authentication
        if (Auth::guard('admin')->attempt($credentials, $remember)) {
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Try staff authentication
        if (Auth::guard('ortu')->attempt($credentials, $remember)) {
            RateLimiter::clear($this->throttleKey());
            return;
        }

        // Try web authentication
        if (Auth::guard('web')->attempt($credentials, $remember)) {
            RateLimiter::clear($this->throttleKey());
            return;
        }
        Session::put('username', $credentials['username']);
        // If none of the authentication attempts succeed
        RateLimiter::hit($this->throttleKey());
        throw ValidationException::withMessages([
            'username' => trans('auth.failed'),
        ]);
    }

    /**
     * Ensure the login request is not rate limited.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function ensureIsNotRateLimited(): void
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'username' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    /**
     * Get the rate limiting throttle key for the request.
     */
    public function throttleKey(): string
    {
        return Str::transliterate(Str::lower($this->string('username')).'|'.$this->ip());
    }

    /**
     * Store username and user type in session.
     */

}