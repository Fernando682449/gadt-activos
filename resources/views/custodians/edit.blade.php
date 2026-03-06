<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Editar Custodio</h2>
                <p class="page-subtitle">
                    Actualiza la información del funcionario responsable de activos.
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('custodians.show', $custodian) }}" class="btn-ghost">
                    ← Volver
                </a>

                <a href="{{ route('custody.show', $custodian) }}" class="btn-outline">
                    📦 Ver activos en custodia
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 page-bg">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- alertas --}}
            @if(session('success'))
                <div class="alert-success">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert-danger">
                    <div class="font-semibold mb-2">Corrige lo siguiente:</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                    <div>
                        <div class="section-title">Formulario de edición</div>
                        <div class="section-subtitle">Los campos marcados con * son obligatorios.</div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        @if($custodian->activo)
                            <span class="status-ok">✅ Activo</span>
                        @else
                            <span class="status-neutral">⛔ Inactivo</span>
                        @endif
                        <span class="status-pill bg-gray-100 text-gray-800">👤 Custodio</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('custodians.update', $custodian) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Nombres --}}
                        <div>
                            <label class="label-pro">Nombres *</label>
                            <input
                                type="text"
                                name="nombres"
                                class="input-pro-2 mt-1"
                                value="{{ old('nombres', $custodian->nombres) }}"
                                placeholder="Ej: Juan Carlos"
                                required
                            >
                            @error('nombres')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Apellidos --}}
                        <div>
                            <label class="label-pro">Apellidos *</label>
                            <input
                                type="text"
                                name="apellidos"
                                class="input-pro-2 mt-1"
                                value="{{ old('apellidos', $custodian->apellidos) }}"
                                placeholder="Ej: Pérez López"
                                required
                            >
                            @error('apellidos')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Cargo --}}
                        <div>
                            <label class="label-pro">Cargo</label>
                            <input
                                type="text"
                                name="cargo"
                                class="input-pro-2 mt-1"
                                value="{{ old('cargo', $custodian->cargo) }}"
                                placeholder="Ej: Técnico TI"
                            >
                            @error('cargo')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Unidad --}}
                        <div>
                            <label class="label-pro">Unidad</label>
                            <input
                                type="text"
                                name="unidad"
                                class="input-pro-2 mt-1"
                                value="{{ old('unidad', $custodian->unidad) }}"
                                placeholder="Ej: DTI"
                            >
                            @error('unidad')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Email</label>
                            <input
                                type="email"
                                name="email"
                                class="input-pro-2 mt-1"
                                value="{{ old('email', $custodian->email) }}"
                                placeholder="ejemplo@correo.com"
                            >
                            @error('email')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Estado *</label>
                            <select name="activo" class="select-pro-2 mt-1" required>
                                <option value="1" @selected(old('activo', (int)$custodian->activo) === 1)>Activo</option>
                                <option value="0" @selected(old('activo', (int)$custodian->activo) === 0)>Inactivo</option>
                            </select>
                            @error('activo')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <p class="text-xs text-gray-500 mt-2">
                                Si lo marcas como “Inactivo”, ya no debería aparecer para nuevas asignaciones.
                            </p>
                        </div>

                    </div>

                    {{-- Acciones --}}
                    <div class="pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-xs text-gray-500">
                            Al guardar, los cambios se verán reflejados en el módulo de Custodios.
                        </div>

                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('custodians.show', $custodian) }}" class="btn-ghost">
                                Cancelar
                            </a>
                            <button type="submit" class="btn-brand">
                                Guardar cambios
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>