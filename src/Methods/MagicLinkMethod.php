<?php

namespace DavidGut\SimpleAuth\Methods;

use DavidGut\SimpleAuth\Mail\MagicLinkEmail;
use DavidGut\SimpleAuth\Method;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class MagicLinkMethod extends Method
{
    public function getName(): string
    {
        return 'Magic link';
    }

    public function getDescription(): string
    {
        return 'Login via a secure link sent to your email';
    }

    public function getButtonText(): string
    {
        return 'Email me a magic link';
    }

    public function authenticate(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'email'],
        ]);

        $throttleKey = Str::lower($request->input('email')) . '|' . $request->ip();

        if (RateLimiter::tooManyAttempts($throttleKey, 5)) {
            $seconds = RateLimiter::availableIn($throttleKey);
            throw ValidationException::withMessages([
                'email' => trans('auth.throttle', [
                    'seconds' => $seconds,
                    'minutes' => ceil($seconds / 60),
                ]),
            ]);
        }

        $userModel = config('auth.providers.users.model', \App\Models\User::class);
        $user = $userModel::where('email', $request->input('email'))->first();

        if ($user) {
            $this->sendMagicLink($user);
        }

        RateLimiter::hit($throttleKey);

        return back()->with('info', [
            'title' => 'Magic link sent!',
            'message' => 'We have emailed you a magic link to sign in.',
        ]);
    }

    private function sendMagicLink($user): void
    {
        $loginUrl = $this->createLoginUrl($user);
        Mail::to($user)->send(new MagicLinkEmail($loginUrl));
    }

    private function createLoginUrl($user): string
    {
        return URL::temporarySignedRoute(
            name: 'magic_link',
            expiration: now()->addMinutes(config('simple-auth.methods.magic_link.ttl', 15)),
            parameters: [
                'user' => $user->getKey(),
                'hash' => $this->createLoginHash($user),
                'redirect' => config('simple-auth.redirect_after_login', '/'),
            ]
        );
    }

    public function createLoginHash($user): string
    {
        return hash_hmac(
            algo: 'sha256',
            data: $user->getKey() . $user->email . $user->created_at->timestamp,
            key: config('app.key')
        );
    }

    private function getUserModel(): string
    {
        return config('auth.providers.users.model', \App\Models\User::class);
    }

    private function getUserTable(): string
    {
        $model = $this->getUserModel();
        return (new $model)->getTable();
    }

    /**
     * Check if mail is configured (required dependency for magic links)
     */
    protected function hasRequiredDependencies(): bool
    {
        return config('mail.default') !== null;
    }
}
