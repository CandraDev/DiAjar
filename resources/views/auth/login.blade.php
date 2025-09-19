<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    {{-- {{dd(Auth::user())}} --}}


    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        {{-- {{dd(Auth::user())}} --}}
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email"
                :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full" type="password" name="password"
                required autocomplete="current-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center">
                <input id="remember_me" type="checkbox"
                    class="rounded border-gray-300 text-indigo-600 shadow-sm focus:ring-indigo-500"
                    name="remember">
                <span class="ms-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="flex items-center justify-end mt-4">
            @if (Route::has('password.request'))
                <a class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                    href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
            @endif

            <x-primary-button class="ms-3">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Divider -->
    <div class="flex items-center my-6">
        <div class="flex-grow border-t border-gray-300"></div>
        <span class="mx-3 text-gray-500 text-sm">or</span>
        <div class="flex-grow border-t border-gray-300"></div>
    </div>

    <!-- Google Login -->
    <a href="{{ route('google.login') }}"
       class="flex items-center justify-center w-full px-4 py-2 text-white bg-red-500 rounded-lg hover:bg-red-600 transition-colors">
        <svg class="w-5 h-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
            <path
                d="M21.35 11.1H12v2.8h5.35c-.25 1.45-1.55 4.25-5.35 4.25-3.25 0-5.9-2.7-5.9-6s2.65-6 5.9-6c1.85 0 3.1.8 3.8 1.5l2.6-2.5C16.8 3.7 14.6 2.7 12 2.7 6.95 2.7 2.9 6.7 2.9 12s4.05 9.3 9.1 9.3c5.25 0 8.7-3.7 8.7-9 0-.6-.05-1-.15-1.5z" />
        </svg>
        {{ __('Login with Google') }}
    </a>
</x-guest-layout>
