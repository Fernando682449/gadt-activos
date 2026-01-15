<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Mantenimiento
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('maintenances.store') }}">
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
                        <label class="block mb-1">Tipo</label>
                        <select name="tipo" class="w-full border rounded p-2">
                            <option value="PREVENTIVO">PREVENTIVO</option>
                            <option value="CORRECTIVO" selected>CORRECTIVO</option>
                        </select>
                        @error('tipo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Estado</label>
                        <select name="estado" class="w-full border rounded p-2">
                            <option value="ABIERTO">ABIERTO</option>
                            <option value="EN_PROCESO">EN PROCESO</option>
                            <option value="FINALIZADO">FINALIZADO</option>
                        </select>
                        @error('estado') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Fecha inicio</label>
                        <input type="date" name="fecha_inicio" class="w-full border rounded p-2" value="{{ date('Y-m-d') }}">
                        @error('fecha_inicio') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Fecha fin</label>
                        <input type="date" name="fecha_fin" class="w-full border rounded p-2">
                        @error('fecha_fin') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Proveedor/Técnico</label>
                        <input name="proveedor_tecnico" class="w-full border rounded p-2">
                        @error('proveedor_tecnico') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Costo</label>
                        <input type="number" step="0.01" name="costo" class="w-full border rounded p-2">
                        @error('costo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Descripción de falla</label>
                        <textarea name="descripcion_falla" class="w-full border rounded p-2" rows="3"></textarea>
                        @error('descripcion_falla') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Trabajo realizado</label>
                        <textarea name="trabajo_realizado" class="w-full border rounded p-2" rows="3"></textarea>
                        @error('trabajo_realizado') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-2 mt-4">
                        <a href="{{ route('assets.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-border rounded hover:bg-blue-700">
                            Guardar Mantenimiento
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
