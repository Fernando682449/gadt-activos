<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Registrar Asignación / Reasignación</h2>
                <p class="page-subtitle">
                    Completa los datos para registrar un movimiento de activo (asignación, reasignación o traslado).
                </p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

            {{-- Errores generales --}}
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

            <div class="card p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4 mb-6">
                    <div>
                        <div class="section-title">Formulario de movimiento</div>
                        <div class="section-subtitle">Los campos marcados con * son obligatorios.</div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="status-pill bg-gray-100 text-gray-800">📌 Movimiento</span>
                        <span class="status-pill bg-brand-100 text-brand-800">✅ Registro</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('assignments.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Activo --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Activo *</label>
                            <select name="asset_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($assets as $a)
                                    <option value="{{ $a->id }}" @selected(old('asset_id') == $a->id)>
                                        {{ $a->codigo_patrimonial }}
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Custodio --}}
                        <div>
                            <label class="label-pro">Custodio *</label>
                            <select name="custodian_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($custodians as $c)
                                    <option value="{{ $c->id }}" @selected(old('custodian_id') == $c->id)>
                                        {{ $c->nombre_completo }}
                                    </option>
                                @endforeach
                            </select>
                            @error('custodian_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Ubicación --}}
                        <div>
                            <label class="label-pro">Ubicación *</label>
                            <select name="location_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione --</option>
                                @foreach($locations as $l)
                                    <option value="{{ $l->id }}" @selected(old('location_id') == $l->id)>
                                        {{ $l->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('location_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipo de movimiento --}}
                        <div>
                            <label class="label-pro">Tipo de movimiento *</label>
                            <select name="tipo_movimiento" class="select-pro-2 mt-1" required>
                                <option value="ASIGNACION" @selected(old('tipo_movimiento') == 'ASIGNACION')>ASIGNACIÓN</option>
                                <option value="REASIGNACION" @selected(old('tipo_movimiento') == 'REASIGNACION')>REASIGNACIÓN</option>
                                <option value="TRASLADO" @selected(old('tipo_movimiento') == 'TRASLADO')>TRASLADO</option>
                            </select>
                            @error('tipo_movimiento')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <p class="text-xs text-gray-500 mt-2">
                                ASIGNACIÓN: primera entrega • REASIGNACIÓN: cambio de custodio • TRASLADO: cambio de ubicación
                            </p>
                        </div>

                        {{-- Fecha --}}
                        <div>
                            <label class="label-pro">Fecha *</label>
                            <input
                                type="date"
                                name="fecha_asignacion"
                                class="input-pro-2 mt-1"
                                value="{{ old('fecha_asignacion', date('Y-m-d')) }}"
                                required
                            >
                            @error('fecha_asignacion')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Observaciones --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Observaciones</label>
                            <textarea
                                name="observaciones"
                                class="textarea-pro mt-1"
                                rows="3"
                                placeholder="Ej: Entrega por reasignación, cambio de ambiente, préstamo temporal, etc."
                            >{{ old('observaciones') }}</textarea>
                            @error('observaciones')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    {{-- Acciones --}}
                    <div class="pt-5 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-xs text-gray-500">
                            Al guardar, el movimiento quedará registrado y podrá reflejarse en la bitácora.
                        </div>

                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('assets.index') }}" class="btn-ghost">
                                Cancelar
                            </a>
                            <button type="submit" class="btn-brand">
                                Guardar Movimiento
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>
</x-app-layout>