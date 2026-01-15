<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar Custodio
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('custodians.update', $custodian) }}">
                    @csrf
                    @method('PUT')

                    <div class="mb-4">
                        <label class="block mb-1">Nombres</label>
                        <input name="nombres" class="w-full border rounded p-2"
                               value="{{ old('nombres', $custodian->nombres) }}">
                        @error('nombres') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Apellidos</label>
                        <input name="apellidos" class="w-full border rounded p-2"
                               value="{{ old('apellidos', $custodian->apellidos) }}">
                        @error('apellidos') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Cargo</label>
                        <input name="cargo" class="w-full border rounded p-2"
                               value="{{ old('cargo', $custodian->cargo) }}">
                        @error('cargo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Unidad</label>
                        <input name="unidad" class="w-full border rounded p-2"
                               value="{{ old('unidad', $custodian->unidad) }}">
                        @error('unidad') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Email</label>
                        <input name="email" class="w-full border rounded p-2"
                               value="{{ old('email', $custodian->email) }}">
                        @error('email') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Estado</label>
                        <select name="activo" class="w-full border rounded p-2">
                            <option value="1" @selected(old('activo', (string)$custodian->activo) == '1')>Activo</option>
                            <option value="0" @selected(old('activo', (string)$custodian->activo) == '0')>Inactivo</option>
                        </select>
                        @error('activo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('custodians.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-border rounded hover:bg-blue-700">
                            Actualizar
                        </button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
