<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <div class="text-center mb-6">
        <h2 class="text-2xl font-bold text-base-content">Welcome Back</h2>
        <p class="text-sm text-base-content/60 mt-1">Sign in to continue to Library App</p>
    </div>

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />
            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me -->
        <div class="block mt-4">
            <label for="remember_me" class="inline-flex items-center cursor-pointer">
                <input id="remember_me" type="checkbox" class="checkbox checkbox-primary checkbox-sm rounded" name="remember">
                <span class="ms-2 text-sm text-base-content/70">{{ __('Remember me') }}</span>
            </label>
        </div>

        <div class="mt-6">
            <x-primary-button class="w-full justify-center">
                <i class="fa-solid fa-right-to-bracket mr-2"></i>
                {{ __('Log in') }}
            </x-primary-button>
        </div>

        <div class="text-center mt-5">
            <span class="text-sm text-base-content/60">Don't have an account?</span>
            <a href="{{ route('register') }}" class="text-sm text-primary font-semibold hover:text-primary/80 transition ml-1">Register</a>
        </div>
    </form>
</x-guest-layout>
