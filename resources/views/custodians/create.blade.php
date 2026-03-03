<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Registrar Custodio</h2>
                <p class="page-subtitle">Crea un responsable para asignaciones de activos.</p>
            </div>

            <a href="{{ route('custodians.index') }}" class="btn-ghost">
                ← Volver
            </a>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            {{-- Errores generales --}}
            @if($errors->any())
                <div class="alert-danger mb-6">
                    <div class="font-semibold mb-1">Revisa los campos marcados</div>
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-hover p-6 sm:p-7">
                <form method="POST" action="{{ route('custodians.store') }}" class="space-y-5">
                    @csrf

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Nombres --}}
                        <div>
                            <label class="label-pro">Nombres <span class="text-red-500">*</span></label>
                            <input
                                name="nombres"
                                value="{{ old('nombres') }}"
                                class="input-pro @error('nombres') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                
                            >
                            @error('nombres')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Apellidos --}}
                        <div>
                            <label class="label-pro">Apellidos <span class="text-red-500">*</span></label>
                            <input
                                name="apellidos"
                                value="{{ old('apellidos') }}"
                                class="input-pro @error('apellidos') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                
                            >
                            @error('apellidos')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        {{-- Cargo --}}
                        <div>
                            <label class="label-pro">Cargo</label>
                            <input
                                name="cargo"
                                value="{{ old('cargo') }}"
                                class="input-pro @error('cargo') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Ej: Técnico TI"
                            >
                            @error('cargo')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Unidad --}}
                        <div>
                            <label class="label-pro">Unidad</label>
                            <input
                                name="unidad"
                                value="{{ old('unidad') }}"
                                class="input-pro @error('unidad') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                                placeholder="Ej: DTI"
                            >
                            @error('unidad')
                                <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    {{-- Email --}}
                    <div>
                        <label class="label-pro">Email</label>
                        <input
                            type="email"
                            name="email"
                            value="{{ old('email') }}"
                            class="input-pro @error('email') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                            placeholder="Ej: usuario@tarija.gob.bo"
                        >
                        @error('email')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Estado --}}
                    <div>
                        <label class="label-pro">Estado</label>
                        <select
                            name="activo"
                            class="select-pro @error('activo') border-red-300 focus:border-red-500 focus:ring-red-500 @enderror"
                        >
                            <option value="1" @selected(old('activo', '1') == '1')>Activo</option>
                            <option value="0" @selected(old('activo') == '0')>Inactivo</option>
                        </select>
                        @error('activo')
                            <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Acciones --}}
                    <div class="pt-2 flex flex-col sm:flex-row gap-3 sm:justify-end">
                        <a href="{{ route('custodians.index') }}" class="btn-outline">
                            Cancelar
                        </a>
                        <button type="submit" class="btn-brand">
                            Guardar Custodio
                        </button>
                    </div>

                </form>
            </div>

            <p class="mt-4 text-xs text-gray-500 text-center">
                Los campos con <span class="text-red-500">*</span> son obligatorios.
            </p>

        </div>
    </div>
</x-app-layout>