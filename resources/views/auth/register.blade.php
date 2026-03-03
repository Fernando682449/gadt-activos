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

            <h2 class="login-title mt-4">Crear cuenta</h2>
            <p class="login-subtitle">Registra un nuevo usuario para acceder al sistema</p>
        </div>

        <x-validation-errors class="mb-4" />

        <form method="POST" action="{{ route('register') }}" class="space-y-5">
            @csrf

            <div>
                <label for="name" class="label-pro">Nombre completo</label>
                <input id="name"
                       name="name"
                       type="text"
                       value="{{ old('name') }}"
                       required
                       autofocus
                       autocomplete="name"
                       class="input-pro"
                       placeholder="Ej: Juan Pérez">
            </div>

            <div>
                <label for="email" class="label-pro">Correo electrónico</label>
                <input id="email"
                       name="email"
                       type="email"
                       value="{{ old('email') }}"
                       required
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
                       autocomplete="new-password"
                       class="input-pro"
                       placeholder="••••••••">
                <p class="mt-1 text-xs text-gray-500">
                    Usa una contraseña segura (mínimo 8 caracteres).
                </p>
            </div>

            <div>
                <label for="password_confirmation" class="label-pro">Confirmar contraseña</label>
                <input id="password_confirmation"
                       name="password_confirmation"
                       type="password"
                       required
                       autocomplete="new-password"
                       class="input-pro"
                       placeholder="••••••••">
            </div>

            <button type="submit" class="btn-primary w-full py-3 text-base">
                Registrar usuario
            </button>

            <div class="text-center">
                <a href="{{ route('login') }}" class="text-sm font-semibold text-brand-700 hover:text-brand-800 smooth">
                    ¿Ya tienes cuenta? Inicia sesión
                </a>
            </div>

            <p class="text-center text-xs text-gray-500 mt-2">
                Si tienes problemas de acceso, contacta al administrador.
            </p>
        </form>
    </div>
</x-guest-layout>