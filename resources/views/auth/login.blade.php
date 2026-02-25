<x-guest-layout>

    <div class="bg-white border border-gray-200 rounded-2xl shadow-soft p-8">

        {{-- ✅ Logo + título arriba del login --}}
        <div class="flex items-center gap-3 mb-6">
            <img src="{{ asset('img/2.jpg') }}"
                 class="h-12 w-12 object-contain rounded bg-gray-50 p-1 border border-gray-200"
                 alt="Logo">
            <div class="leading-tight">
                <div class="text-lg font-bold text-gray-900">GADT - Tarija</div>
            </div>
        </div>

        {{-- Header del formulario --}}
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Iniciar sesión</h1>
            <p class="text-sm text-gray-600 mt-1">Accede al sistema de gestión de activos</p>
        </div>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="mb-4 text-sm font-medium text-green-700 bg-green-50 border border-green-200 rounded-lg p-3">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-4">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-700">
                    Correo electrónico
                </label>
                <input id="email" name="email" type="email" value="{{ old('email') }}"
                       required autofocus autocomplete="username"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                              focus:border-brand-600 focus:ring-brand-600">
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-700">
                    Contraseña
                </label>
                <input id="password" name="password" type="password"
                       required autocomplete="current-password"
                       class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm
                              focus:border-brand-600 focus:ring-brand-600">
            </div>

            <div class="flex items-center justify-between">
                <label for="remember_me" class="flex items-center text-sm text-gray-600">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="rounded border-gray-300 text-brand-600 shadow-sm focus:ring-brand-600">
                    <span class="ml-2">Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="text-sm font-medium text-brand-700 hover:text-brand-800 hover:underline"
                       href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit"
                    class="w-full py-2.5 px-4 rounded-lg bg-brand-600 hover:bg-brand-700
                           text-white font-semibold transition">
                Ingresar
            </button>

            <div class="pt-2 text-center text-xs text-gray-500">
                Si tienes problemas de acceso, contacta al administrador.
            </div>
        </form>

    </div>

</x-guest-layout>