<x-guest-layout>
    <x-auth-card>
        <x-slot name="logo">
            <a href="/">
                <x-login-logo class="fill-current text-gray-500 w-64"/>
            </a>
        </x-slot>

        <!-- Session Status -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- Validation Errors -->
        <x-auth-validation-errors class="mb-4" :errors="$errors" />

        <form method="POST" action="{{ route('login') }}">
            @csrf
            <div class="border-2 border-black text-center text-lg">
                <b>Inicia sesión</b>
            </div>

            <!-- Email Address -->
            <div class="pt-4">
                <x-label class="font-semibold text-base" for="email" :value="__('Correo electrónico')" />

                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus />
            </div>

            <!-- Password -->
            <div class="mt-4">
                <x-label class="font-semibold text-base" for="password" :value="__('Contraseña')" />

                <x-input id="password" class="block mt-1 w-full"
                                type="password"
                                name="password"
                                required autocomplete="current-password" />
            </div>

            <!-- Remember Me -->
            <div class="block mt-4">
                <label for="remember_me" class="inline-flex items-center">
                    <input id="remember_me" type="checkbox" class="rounded border-gray-300 text-indigo-600 shadow-sm focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50" name="remember">
                    <span class="ml-2 text-sm text-gray-600">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-between mt-4">
                    <a class="text-sm text-gray-600 hover:text-green-900" href="{{ route('register') }}">
                        <x-button type="button">
                            {{ __('Registrarse') }}
                        </x-button>
                    </a>

                @if (Route::has('password.request'))
                    <a class="underline text-sm text-gray-600 hover:text-green-900" href="{{ route('password.request') }}">
                        {{ __('¿Contraseña olvidada?') }}
                    </a>
                @endif

                <x-button class="ml-3 bg-green-600">
                    {{ __('Entrar') }}
                </x-button>
            </div>
        </form>
    </x-auth-card>
</x-guest-layout>
