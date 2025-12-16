<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Auth Methods
    |--------------------------------------------------------------------------
    |
    | The authentication methods that should be enabled for your application.
    |
    */
    'methods' => [
        'magic_link' => [
            'class' => \DavidGut\SimpleAuth\Methods\MagicLinkMethod::class,
            'ttl' => env('SIMPLE_AUTH_MAGIC_LINK_TTL', 15), // minutes,
            'enabled' => env('SIMPLE_AUTH_MAGIC_LINK_ENABLED', true),
        ],
        'password' => [
            'class' => \DavidGut\SimpleAuth\Methods\PasswordMethod::class,
            'enabled' => env('SIMPLE_AUTH_PASSWORD_ENABLED', true),
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Method
    |--------------------------------------------------------------------------
    |
    | The default method to show when visiting the login page without a specific method.
    |
    */
    'default' => env('SIMPLE_AUTH_DEFAULT_METHOD', 'password'),

    /*
    |--------------------------------------------------------------------------
    | Redirects
    |--------------------------------------------------------------------------
    |
    | Where to redirect users after login and logout.
    |
    */
    'redirect_after_login' => env('SIMPLE_AUTH_REDIRECT_AFTER_LOGIN', '/'),
    'redirect_after_logout' => env('SIMPLE_AUTH_REDIRECT_AFTER_LOGOUT', '/'),
];
