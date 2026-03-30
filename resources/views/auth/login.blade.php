<x-guest-layout>
    <div class="login-card">
        <div class="text-center">
            {{-- Logo arriba del título --}}
            <div class="mx-auto mb-4 h-14 w-14 rounded-2xl bg-white shadow-soft flex items-center justify-center overflow-hidden border">
                <img src="{{ asset('img/2.jpg') }}" alt="Logo" class="h-10 w-10 object-contain">
            </div>

            <div class="text-xs font-semibold tracking-widest text-gray-700">
                GOBIERNO AUTÓNOMO
            </div>
            <div class="text-xs font-semibold tracking-widest text-gray-700">
                DEPARTAMENTAL DE TARIJA
            </div>

            <h2 class="login-title mt-4">Iniciar sesión</h2>
            <p class="login-subtitle">Accede al sistema de gestión de activos</p>

        
        </div>

        <x-validation-errors class="mb-4" />

        @if (session('status'))
            <div class="alert-success mb-4">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('login') }}" class="space-y-5">
            @csrf

            <div>
                <label for="email" class="label-pro">Correo electrónico</label>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email') }}"
                       required
                       autofocus
                       autocomplete="username"
                       class="input-pro"
                       placeholder="ejemplo@correo.com">
            </div>

            <div>
                <label for="password" class="label-pro">Contraseña</label>
                <input id="password"
                       name="password"
                       type="password"
                       required
                       autocomplete="current-password"
                       class="input-pro"
                       placeholder="••••••••">
            </div>
            

            <div class="flex items-center justify-between text-sm">
                <label for="remember_me" class="flex items-center gap-2 text-gray-700">
                    <input id="remember_me" name="remember" type="checkbox"
                           class="rounded border-gray-300 text-brand-600 focus:ring-brand-500">
                    <span>Recordarme</span>
                </label>

                @if (Route::has('password.request'))
                    <a class="font-semibold text-brand-700 hover:text-brand-800 smooth"
                       href="{{ route('password.request') }}">
                        ¿Olvidaste tu contraseña?
                    </a>
                @endif
            </div>

            <button type="submit" class="btn-primary w-full py-3 text-base">
                Ingresar
            </button>
            
        </form>
    </div>
</x-guest-layout>