<?php

namespace DavidGut\SimpleAuth\Http\Controllers;

use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class SignupController extends Controller
{
    public function create(): View
    {
        return view('simple-auth::signup');
    }

    public function store(Request $request): RedirectResponse
    {
        $userModel = config('auth.providers.users.model', \App\Models\User::class);
        $userTable = (new $userModel)->getTable();

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:' . $userTable],
            'password' => ['required', 'string', 'min:8'],
        ]);

        $user = $userModel::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        event(new Registered($user));

        Auth::login($user);

        return redirect()->intended(config('simple-auth.redirect_after_login', '/'));
    }
}
