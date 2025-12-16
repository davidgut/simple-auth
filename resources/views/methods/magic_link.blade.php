<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('simple-auth::messages.login') - {{ config('app.name') }}</title>
    <link href="{{ asset('vendor/simple-auth/simple-auth.css') }}" rel="stylesheet">
</head>

<body class="bg-gray-50 flex items-center justify-center min-h-screen p-6">
    <div class="w-full max-w-sm">
        <!-- Logo -->
        <div class="text-center mb-8">
            <a href="/" class="inline-flex items-center gap-3">
                <span class="font-semibold text-xl text-gray-900">{{ config('app.name') }}</span>
            </a>
        </div>

        <!-- Magic Link Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h1 class="text-lg font-semibold text-gray-900 mb-1">@lang('simple-auth::messages.welcome_back')</h1>
            <p class="text-sm text-gray-500 mb-6">@lang('simple-auth::messages.magic_link_intro')</p>

            @if (session('info'))
                <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                    <p class="text-sm font-medium text-green-800">{{ session('info.title') }}</p>
                    <p class="text-sm text-green-700">{{ session('info.message') }}</p>
                </div>
            @endif

            <form method="POST" action="{{ route('simple-auth.login.store', $currentAuthMethod->getIdentifier()) }}"
                class="space-y-4">
                @csrf

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-900 mb-1.5">@lang('simple-auth::messages.email')</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required autofocus
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-gray-800 text-white py-2.5 px-4 rounded-lg text-sm font-medium transition-colors">
                    @lang('simple-auth::messages.send_magic_link')
                </button>

                @include('simple-auth::methods._method_buttons')
            </form>
        </div>

        <!-- Signup Link -->
        <p class="text-center text-sm text-gray-500 mt-6">
            @lang('simple-auth::messages.dont_have_account')
            <a href="{{ route('simple-auth.signup') }}"
                class="text-gray-600 hover:text-gray-900 font-medium">@lang('simple-auth::messages.sign_up')</a>
        </p>
    </div>
</body>

</html>