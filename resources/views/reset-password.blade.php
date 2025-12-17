<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('simple-auth::messages.reset_password') - {{ config('app.name') }}</title>
    <link href="{{ asset('vendor/simple-auth/simple-auth.css') }}" rel="stylesheet">
</head>

<body class="flex items-center justify-center min-h-screen">
    <div class="w-full max-w-xs">
        <!-- Logo -->
        <div class="mb-8">
            <a href="/" class="inline-flex items-center gap-3">
                <span class="font-semibold text-xl text-gray-900">{{ config('app.name') }}</span>
            </a>
        </div>

        <!-- Reset Password Form -->
        <h1 class="text-lg font-semibold text-gray-900 mb-1">@lang('simple-auth::messages.reset_password')</h1>

        <form method="POST" action="{{ route('simple-auth.password.update') }}" class="space-y-4">
            @csrf

            <!-- Password Reset Token -->
            <input type="hidden" name="token" value="{{ $token }}">

            <div>
                <label for="email"
                    class="block text-sm font-medium text-gray-900 mb-1.5">@lang('simple-auth::messages.email')</label>
                <input type="email" id="email" name="email" value="{{ old('email', $request->email) }}" required
                    autofocus
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

            <div>
                <label for="password_confirmation"
                    class="block text-sm font-medium text-gray-900 mb-1.5">@lang('simple-auth::messages.confirm_password')</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required
                    class="w-full px-3 py-2 rounded-lg border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-gray-500 focus:border-transparent"
                    placeholder="••••••••">
                @error('password_confirmation')
                    <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit"
                    class="w-full bg-gray-900 hover:bg-gray-800 text-white py-2.5 px-4 rounded-lg text-sm font-medium transition-colors">
                    @lang('simple-auth::messages.reset_password')
                </button>
            </div>
        </form>
    </div>
</body>

</html>