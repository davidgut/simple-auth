@if($authMethods->isNotEmpty())
    <div class="relative my-6">
        <div class="absolute inset-0 flex items-center" aria-hidden="true">
            <div class="w-full border-t border-gray-200"></div>
        </div>
        <div class="relative flex justify-center text-sm">
            <span class="px-2 text-gray-500">Or continue with</span>
        </div>
    </div>

    <div class="space-y-3">
        @foreach($authMethods as $method)
            <a href="{{ route('simple-auth.login.show', $method->getIdentifier()) }}"
                class="flex w-full justify-center rounded-lg border border-gray-300 bg-white px-4 py-2.5 text-sm font-medium text-gray-700 shadow-sm hover:bg-gray-50 transition-colors">
                {{ $method->getButtonText() }}
            </a>
        @endforeach
    </div>
@endif