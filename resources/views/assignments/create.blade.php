<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Asignación / Reasignación
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('assignments.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1">Activo</label>
                        <select name="asset_id" class="w-full border rounded p-2">
                            <option value="">-- Seleccione --</option>
                            @foreach($assets as $a)
                                <option value="{{ $a->id }}">{{ $a->codigo_patrimonial }}</option>
                            @endforeach
                        </select>
                        @error('asset_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Custodio</label>
                        <select name="custodian_id" class="w-full border rounded p-2">
                            <option value="">-- Seleccione --</option>
                            @foreach($custodians as $c)
                                <option value="{{ $c->id }}">{{ $c->nombre_completo }}</option>
                            @endforeach
                        </select>
                        @error('custodian_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Ubicación</label>
                        <select name="location_id" class="w-full border rounded p-2">
                            <option value="">-- Seleccione --</option>
                            @foreach($locations as $l)
                                <option value="{{ $l->id }}">{{ $l->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Tipo de movimiento</label>
                        <select name="tipo_movimiento" class="w-full border rounded p-2">
                            <option value="ASIGNACION">ASIGNACIÓN</option>
                            <option value="REASIGNACION">REASIGNACIÓN</option>
                            <option value="TRASLADO">TRASLADO</option>
                        </select>
                        @error('tipo_movimiento') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Fecha</label>
                        <input type="date" name="fecha_asignacion" class="w-full border rounded p-2" value="{{ date('Y-m-d') }}">
                        @error('fecha_asignacion') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Observaciones</label>
                        <textarea name="observaciones" class="w-full border rounded p-2" rows="3"></textarea>
                        @error('observaciones') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('assets.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-border rounded hover:bg-blue-700">
                            Guardar Movimiento
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
