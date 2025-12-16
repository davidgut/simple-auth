<?php

namespace DavidGut\SimpleAuth\Http\Controllers;

use DavidGut\SimpleAuth\Methods\MagicLinkMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class MagicLinkController extends Controller
{
    public function __invoke(Request $request, $user, string $hash): RedirectResponse
    {
        if (!$request->hasValidSignature()) {
            abort(401, 'This magic link has expired.');
        }

        $userModel = config('auth.providers.users.model', \App\Models\User::class);
        $user = $userModel::findOrFail($user);

        $authMethod = new MagicLinkMethod();

        if (!hash_equals($authMethod->createLoginHash($user), $hash)) {
            abort(401, 'Invalid magic link.');
        }

        Auth::login($user, remember: true);

        $request->session()->regenerate();

        return redirect()->intended($request->query('redirect', config('simple-auth.redirect_after_login', '/')));
    }
}
