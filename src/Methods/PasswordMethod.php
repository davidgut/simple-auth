<?php

namespace DavidGut\SimpleAuth\Methods;

use DavidGut\SimpleAuth\Method;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Lockout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Validation\ValidationException;

class PasswordMethod extends Method
{
    public function getName(): string
    {
        return 'Password';
    }

    public function getDescription(): string
    {
        return 'Login with your email and password';
    }

    public function getButtonText(): string
    {
        return 'Login with email & password';
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $this->validateRequest($request);
        $this->ensureIsNotRateLimited($request);

        if (!Auth::attempt($request->only('email', 'password'), $request->boolean('remember'))) {
            RateLimiter::hit($this->getThrottleKey($request));

            throw ValidationException::withMessages([
                'email' => 'The email or password are incorrect.',
            ]);
        }

        RateLimiter::clear($this->getThrottleKey($request));

        $request->session()->regenerate();

        return redirect()->intended(config('simple-auth.redirect_after_login', '/'));
    }

    protected function validateRequest(Request $request): void
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
        ]);
    }

    protected function ensureIsNotRateLimited(Request $request): void
    {
        if (!RateLimiter::tooManyAttempts($this->getThrottleKey($request), 5)) {
            return;
        }

        event(new Lockout($request));

        $seconds = RateLimiter::availableIn($this->getThrottleKey($request));

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    protected function getThrottleKey(Request $request): string
    {
        return Str::transliterate(Str::lower($request->input('email')) . '|' . $request->ip());
    }
}
