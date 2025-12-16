<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('simple-auth::messages.sign_up') - {{ config('app.name') }}</title>
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

        <!-- Signup Form -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-6">
            <h1 class="text-lg font-semibold text-gray-900 mb-1">@lang('simple-auth::messages.create_account')</h1>
            <p class="text-sm text-gray-500 mb-6">
                @lang('simple-auth::messages.get_started_with', ['app' => config('app.name')])
            </p>

            <form method="POST" action="{{ route('simple-auth.signup') }}" class="space-y-4">
                @csrf

                <div>
                    <label for="name"
                        class="block text-sm font-medium text-gray-900 mb-1.5">@lang('simple-auth::messages.name')</label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                        placeholder="Your name">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email"
                        class="block text-sm font-medium text-gray-900 mb-1.5">@lang('simple-auth::messages.email')</label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                        placeholder="you@example.com">
                    @error('email')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="password"
                        class="block text-sm font-medium text-gray-900 mb-1.5">@lang('simple-auth::messages.password')</label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                        placeholder="••••••••">
                    @error('password')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-gray-800 text-white py-2.5 px-4 rounded-lg text-sm font-medium transition-colors">
                    @lang('simple-auth::messages.create_account_action')
                </button>
            </form>
        </div>

        <!-- Login Link -->
        <p class="text-center text-sm text-gray-500 mt-6">
            @lang('simple-auth::messages.already_have_account')
            <a href="{{ route('simple-auth.login') }}"
                class="text-blue-600 hover:text-blue-700 font-medium">@lang('simple-auth::messages.sign_in')</a>
        </p>
    </div>
</body>

</html>