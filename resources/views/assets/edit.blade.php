<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Editar Activo</h2>
                <p class="page-subtitle">Actualiza la información registrada del activo en el sistema.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('assets.index') }}" class="btn-ghost">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

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
                        <div class="section-title">Formulario de edición</div>
                        <div class="section-subtitle">Los campos marcados con * son obligatorios.</div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="status-pill bg-brand-100 text-brand-800">Activos</span>
                        <span class="status-pill bg-gray-100 text-gray-800">Edición</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('assets.update', $asset) }}" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Código --}}
                        <div>
                            <label class="label-pro">Código patrimonial *</label>
                            <div class="relative mt-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🏷️</span>
                                <input
                                    type="text"
                                    name="codigo_patrimonial"
                                    value="{{ old('codigo_patrimonial', $asset->codigo_patrimonial) }}"
                                    class="input-pro-2 pl-9"
                                    placeholder="Ej: DTI-2026-001"
                                    required
                                >
                            </div>
                            @error('codigo_patrimonial')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Serie --}}
                        <div>
                            <label class="label-pro">Número de serie</label>
                            <div class="relative mt-1">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔢</span>
                                <input
                                    type="text"
                                    name="numero_serie"
                                    value="{{ old('numero_serie', $asset->numero_serie) }}"
                                    class="input-pro-2 pl-9"
                                    placeholder="Ej: SN-12345"
                                >
                            </div>
                            @error('numero_serie')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipo --}}
                        <div>
                            <label class="label-pro">Tipo *</label>
                            <select name="asset_type_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($types as $t)
                                    <option value="{{ $t->id }}" @selected(old('asset_type_id', $asset->asset_type_id) == $t->id)>
                                        {{ $t->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_type_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="label-pro">Estado *</label>
                            <select name="status_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($statuses as $s)
                                    <option value="{{ $s->id }}" @selected(old('status_id', $asset->status_id) == $s->id)>
                                        {{ $s->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ubicación --}}
                        <div>
                            <label class="label-pro">Ubicación *</label>
                            <select name="location_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($locations as $l)
                                    <option value="{{ $l->id }}" @selected(old('location_id', $asset->location_id) == $l->id)>
                                        {{ $l->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Marca --}}
                        <div>
                            <label class="label-pro">Marca</label>
                            <select name="brand_id" class="select-pro-2 mt-1">
                                <option value="">-- Seleccione --</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}" @selected(old('brand_id', $asset->brand_id) == $b->id)>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('brand_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Responsable --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Responsable / Custodio *</label>
                            <select name="custodian_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione al responsable --</option>
                                @foreach($custodians as $custodian)
                                    <option value="{{ $custodian->id }}" @selected(old('custodian_id', $asset->custodian_id) == $custodian->id)>
                                        {{ $custodian->nombre_completo ?? trim(($custodian->nombres ?? '') . ' ' . ($custodian->apellidos ?? '')) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('custodian_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fecha de compra --}}
                        <div>
                            <label class="label-pro">Fecha de compra</label>
                            <input
                                type="date"
                                name="fecha_compra"
                                value="{{ old('fecha_compra', $asset->fecha_compra) }}"
                                class="input-pro-2 mt-1"
                            >
                            @error('fecha_compra')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Costo --}}
                        <div>
                            <label class="label-pro">Costo</label>
                            <input
                                type="number"
                                step="0.01"
                                name="costo"
                                value="{{ old('costo', $asset->costo) }}"
                                class="input-pro-2 mt-1"
                                placeholder="0.00"
                            >
                            @error('costo')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Número de factura --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">N° de factura</label>
                            <input
                                type="text"
                                name="nro_factura"
                                value="{{ old('nro_factura', $asset->nro_factura) }}"
                                class="input-pro-2 mt-1"
                                placeholder="Ej: FAC-2026-001"
                            >
                            @error('nro_factura')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Observaciones --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Observaciones</label>
                            <textarea
                                name="observaciones"
                                class="textarea-pro mt-1"
                                rows="4"
                                placeholder="Detalle adicional del activo"
                            >{{ old('observaciones', $asset->observaciones) }}</textarea>
                            @error('observaciones')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <div class="pt-5 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-xs text-gray-500">
                            Los cambios realizados quedarán registrados en el historial de acciones.
                        </div>

                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('assets.index') }}" class="btn-ghost">
                                Cancelar
                            </a>
                            <button type="submit" class="btn-brand">
                                Actualizar activo
                            </button>
                        </div>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>