<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Registrar Activo</h2>
                <p class="page-subtitle">Complete la información para registrar un nuevo activo en el sistema.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('assets.index') }}" class="btn-ghost">Volver</a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            @if ($errors->any())
                <div class="alert-danger mb-6">
                    <div class="font-semibold mb-1">Revisa los campos marcados</div>
                    <ul class="list-disc ms-5">
                        @foreach ($errors->all() as $error)
                            <li class="text-sm">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-hover overflow-hidden">
                <div class="p-6 border-b border-gray-200 flex items-start justify-between">
                    <div>
                        <div class="text-sm text-gray-500">Formulario</div>
                        <div class="text-xl font-extrabold text-gray-900">Datos del activo</div>
                    </div>
                    <span class="status-ok">Registro</span>
                </div>

                <div class="p-6">
                    <form method="POST" action="{{ route('assets.store') }}" class="space-y-6">
                        @csrf

                        {{-- Código / Serie --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="label-pro">Código patrimonial</label>
                                <input
                                    name="codigo_patrimonial"
                                    class="input-pro-2"
                                    value="{{ old('codigo_patrimonial') }}"
                                    placeholder="Ej: GADT-0001"
                                >
                                @error('codigo_patrimonial')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="label-pro">Número de serie</label>
                                <input
                                    name="numero_serie"
                                    class="input-pro-2"
                                    value="{{ old('numero_serie') }}"
                                    placeholder="Ej: SN123456"
                                >
                                @error('numero_serie')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Tipo / Estado --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="label-pro">Tipo</label>
                                <select name="asset_type_id" class="select-pro-2">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($types as $t)
                                        <option value="{{ $t->id }}" @selected(old('asset_type_id') == $t->id)>
                                            {{ $t->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('asset_type_id')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="label-pro">Estado</label>
                                <select name="status_id" class="select-pro-2">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($statuses as $s)
                                        <option value="{{ $s->id }}" @selected(old('status_id') == $s->id)>
                                            {{ $s->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('status_id')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Ubicación / Marca --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="label-pro">Ubicación</label>
                                <select name="location_id" class="select-pro-2">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($locations as $l)
                                        <option value="{{ $l->id }}" @selected(old('location_id') == $l->id)>
                                            {{ $l->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('location_id')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="label-pro">Marca</label>
                                <select name="brand_id" class="select-pro-2">
                                    <option value="">-- Seleccione --</option>
                                    @foreach($brands as $b)
                                        <option value="{{ $b->id }}" @selected(old('brand_id') == $b->id)>
                                            {{ $b->name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('brand_id')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- Fecha / Costo --}}
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                            <div>
                                <label class="label-pro">Fecha de compra</label>
                                <input
                                    type="date"
                                    name="fecha_compra"
                                    class="input-pro-2"
                                    value="{{ old('fecha_compra') }}"
                                >
                                @error('fecha_compra')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label class="label-pro">Costo</label>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="costo"
                                    class="input-pro-2"
                                    value="{{ old('costo') }}"
                                    placeholder="0.00"
                                >
                                @error('costo')
                                    <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>

                        {{-- N° de factura --}}
                        <div>
                            <label class="label-pro">N° de factura</label>
                            <input
                                type="text"
                                name="nro_factura"
                                class="input-pro-2"
                                value="{{ old('nro_factura') }}"
                                placeholder="Ej: FAC-2026-001"
                            >
                            @error('nro_factura')
                                <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Observaciones --}}
                        <div>
                            <label class="label-pro">Observaciones</label>
                            <textarea
                                name="observaciones"
                                class="input-pro-2"
                                rows="4"
                                placeholder="Detalle adicional del activo (opcional)."
                            >{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <p class="mt-1 text-red-600 text-sm">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Acciones --}}
                        <div class="pt-2 flex flex-col sm:flex-row gap-2 sm:justify-end">
                            <a href="{{ route('assets.index') }}" class="btn-ghost">
                                Cancelar
                            </a>
                            <button type="submit" class="btn-brand">
                                Guardar Activo
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <p class="mt-4 text-xs text-gray-500 text-center">
                Tip: Usa un código patrimonial único para facilitar búsquedas y auditoría.
            </p>

        </div>
    </div>
</x-app-layout>