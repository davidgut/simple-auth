<?php

namespace DavidGut\SimpleAuth\Http\Controllers;

use DavidGut\SimpleAuth\MethodManager;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;

class LoginController extends Controller
{
    public function __construct(
        private MethodManager $methodManager
    ) {
    }

    public function create(): View|RedirectResponse
    {
        $currentAuthMethod = $this->methodManager->getDefaultMethod();

        if (!$currentAuthMethod) {
            abort(503, 'No authentication methods are currently enabled.');
        }

        return view($currentAuthMethod->getViewName(), [
            'currentAuthMethod' => $currentAuthMethod,
            'authMethods' => $this->methodManager->getOtherEnabledMethods($currentAuthMethod),
        ]);
    }

    public function show(string $method): View|RedirectResponse
    {
        $currentAuthMethod = $this->methodManager->getMethod($method);

        if (!$currentAuthMethod) {
            abort(503, 'No authentication methods are currently enabled.');
        }

        return view($currentAuthMethod->getViewName(), [
            'currentAuthMethod' => $currentAuthMethod,
            'authMethods' => $this->methodManager->getOtherEnabledMethods($currentAuthMethod),
        ]);
    }

    public function store(string $method, Request $request): RedirectResponse
    {
        $currentAuthMethod = $this->methodManager->getMethod($method);

        if (!$currentAuthMethod) {
            return to_route('simple-auth.login');
        }

        return $currentAuthMethod->authenticate($request);
    }
}
