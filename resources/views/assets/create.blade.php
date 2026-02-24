<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Registrar Activo
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-6 shadow-sm sm:rounded-lg">

                <form method="POST" action="{{ route('assets.store') }}">
                    @csrf

                    <div class="mb-4">
                        <label class="block mb-1">Código patrimonial</label>
                        <input name="codigo_patrimonial" class="w-full border rounded p-2"
                               value="{{ old('codigo_patrimonial') }}">
                        @error('codigo_patrimonial') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Número de serie</label>
                        <input name="numero_serie" class="w-full border rounded p-2"
                               value="{{ old('numero_serie') }}">
                        @error('numero_serie') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Tipo</label>
                        <select name="asset_type_id" class="w-full border rounded p-2">
                            <option value="">-- Seleccione --</option>
                            @foreach($types as $t)
                                <option value="{{ $t->id }}" @selected(old('asset_type_id') == $t->id)>{{ $t->name }}</option>
                            @endforeach
                        </select>
                        @error('asset_type_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
    <label class="block mb-1">Estado</label>
    <select name="status_id" class="w-full border rounded p-2">
        <option value="">-- Seleccione --</option>
        @foreach($statuses as $s)
            <option value="{{ $s->id }}" @selected(old('status_id') == $s->id)>{{ $s->name }}</option>
        @endforeach
    </select>
    @error('status_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
</div>


                    <div class="mb-4">
                        <label class="block mb-1">Ubicación</label>
                        <select name="location_id" class="w-full border rounded p-2">
                            <option value="">-- Seleccione --</option>
                            @foreach($locations as $l)
                                <option value="{{ $l->id }}" @selected(old('location_id') == $l->id)>{{ $l->name }}</option>
                            @endforeach
                        </select>
                        @error('location_id') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>
                    <div class="mt-4">
    <label class="block text-sm font-medium text-gray-700">Marca</label>
    <select name="brand_id" class="mt-1 block w-full rounded border-gray-300">
        <option value="">-- Seleccione --</option>
        @foreach($brands as $b)
            <option value="{{ $b->id }}" @selected(old('brand_id') == $b->id)>
                {{ $b->name }}
            </option>
        @endforeach
    </select>
</div>

                    <div class="mb-4">
                        <label class="block mb-1">Fecha de compra</label>
                        <input type="date" name="fecha_compra" class="w-full border rounded p-2"
                               value="{{ old('fecha_compra') }}">
                        @error('fecha_compra') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Costo</label>
                        <input type="number" step="0.01" name="costo" class="w-full border rounded p-2"
                               value="{{ old('costo') }}">
                        @error('costo') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="mb-4">
                        <label class="block mb-1">Observaciones</label>
                        <textarea name="observaciones" class="w-full border rounded p-2" rows="3">{{ old('observaciones') }}</textarea>
                        @error('observaciones') <p class="text-red-600 text-sm">{{ $message }}</p> @enderror
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('assets.index') }}" class="px-4 py-2 border rounded">Cancelar</a>
                        <button class="px-4 py-2 bg-blue-600 text-white rounded" type="submit">Guardar</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
</x-app-layout>
