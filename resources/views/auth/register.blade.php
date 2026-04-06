<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Nuevo Usuario</h2>
                <p class="page-subtitle">Registra un nuevo usuario y define el rol que tendrá dentro del sistema.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('users.index') }}" class="btn-outline">
                    👥 Ver usuarios
                </a>

                <a href="{{ route('dashboard') }}" class="btn-ghost">
                    ← Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="alert-danger mb-6">
                    <div class="font-semibold mb-2">Corrige lo siguiente:</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="card p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                    <div>
                        <div class="section-title">Formulario de registro</div>
                        <div class="section-subtitle">La creación de usuarios está controlada por el administrador.</div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="status-pill bg-brand-100 text-brand-800">Usuarios</span>
                        <span class="status-pill bg-gray-100 text-gray-800">Registro</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('users.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <label for="name" class="label-pro">Nombre completo</label>
                        <input id="name"
                               name="name"
                               type="text"
                               value="{{ old('name') }}"
                               required
                               autofocus
                               class="input-pro-2 mt-1"
                               placeholder="Ej: Juan Pérez">
                    </div>

                    <div>
                        <label for="email" class="label-pro">Correo electrónico</label>
                        <input id="email"
                               name="email"
                               type="email"
                               value="{{ old('email') }}"
                               required
                               class="input-pro-2 mt-1"
                               placeholder="ejemplo@correo.com">
                    </div>

                    <div>
                        <label for="role" class="label-pro">Rol del usuario</label>
                        <select id="role" name="role" class="select-pro-2 mt-1" required>
                            <option value="">-- Seleccione un rol --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->name }}" @selected(old('role') == $role->name)>
                                    {{ $role->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="password" class="label-pro">Contraseña</label>
                        <input id="password"
                               name="password"
                               type="password"
                               required
                               class="input-pro-2 mt-1"
                               placeholder="••••••••">
                        <p class="mt-1 text-xs text-gray-500">
                            Usa una contraseña segura de al menos 6 caracteres.
                        </p>
                    </div>

                    <div>
                        <label for="password_confirmation" class="label-pro">Confirmar contraseña</label>
                        <input id="password_confirmation"
                               name="password_confirmation"
                               type="password"
                               required
                               class="input-pro-2 mt-1"
                               placeholder="••••••••">
                    </div>

                    <div class="pt-5 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-xs text-gray-500">
                            El administrador define el acceso y el rol del nuevo usuario.
                        </div>

                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('users.index') }}" class="btn-outline">
                                Ver usuarios
                            </a>

                            <a href="{{ route('dashboard') }}" class="btn-ghost">
                                Cancelar
                            </a>

                            <button type="submit" class="btn-brand">
                                Registrar usuario
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout> 