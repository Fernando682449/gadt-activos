<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Registrar Mantenimiento</h2>
                <p class="page-subtitle">Controla tipo, estado, fechas, costo y detalle del trabajo realizado.</p>
            </div>
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">

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
                        <div class="section-title">Formulario de mantenimiento</div>
                        <div class="section-subtitle">Completa la información para registrar el mantenimiento del activo.</div>
                    </div>

                    <div class="flex flex-wrap gap-2">
                        <span class="status-pill bg-brand-100 text-brand-800">Mantenimiento</span>
                        <span class="status-pill bg-gray-100 text-gray-800">Registro</span>
                    </div>
                </div>

                <form method="POST" action="{{ route('maintenances.store') }}" class="space-y-6">
                    @csrf

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        {{-- Activo --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Activo</label>
                            <select id="asset_id" name="asset_id" class="select-pro-2 mt-1" required>
                                <option value="">-- Seleccione un activo --</option>
                                @foreach($assets as $a)
                                    <option value="{{ $a->id }}" @selected(old('asset_id') == $a->id)>
                                        {{ $a->codigo_patrimonial }}
                                        — {{ $a->type?->name ?? 'Sin tipo' }}
                                        — {{ $a->brand?->name ?? 'Sin marca' }}
                                        — {{ $a->status?->name ?? 'Sin estado' }}
                                        — Resp: {{ $a->custodian?->nombre_completo ?? trim(($a->custodian->nombres ?? '') . ' ' . ($a->custodian->apellidos ?? '')) ?: 'Sin responsable' }}
                                        — Ubicación: {{ $a->location?->name ?? 'Sin ubicación' }}
                                        @if($a->numero_serie)
                                            — Serie: {{ $a->numero_serie }}
                                        @endif
                                    </option>
                                @endforeach
                            </select>
                            @error('asset_id')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Tipo --}}
                        <div>
                            <label class="label-pro">Tipo</label>
                            <select name="tipo" class="select-pro-2 mt-1" required>
                                <option value="PREVENTIVO" @selected(old('tipo', 'CORRECTIVO') == 'PREVENTIVO')>PREVENTIVO</option>
                                <option value="CORRECTIVO" @selected(old('tipo', 'CORRECTIVO') == 'CORRECTIVO')>CORRECTIVO</option>
                            </select>
                            @error('tipo')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Estado --}}
                        <div>
                            <label class="label-pro">Estado</label>
                            <select name="estado" class="select-pro-2 mt-1" required>
                                <option value="ABIERTO" @selected(old('estado') == 'ABIERTO')>ABIERTO</option>
                                <option value="EN_PROCESO" @selected(old('estado') == 'EN_PROCESO')>EN PROCESO</option>
                                <option value="FINALIZADO" @selected(old('estado') == 'FINALIZADO')>FINALIZADO</option>
                            </select>
                            @error('estado')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror

                            <p class="text-xs text-gray-500 mt-2">
                                Sugerencia: cuando termine, marca <b>FINALIZADO</b> y completa la <b>fecha fin</b>.
                            </p>
                        </div>

                        {{-- Fecha inicio --}}
                        <div>
                            <label class="label-pro">Fecha inicio</label>
                            <input
                                type="date"
                                name="fecha_inicio"
                                class="input-pro-2 mt-1"
                                value="{{ old('fecha_inicio', date('Y-m-d')) }}"
                                required
                            >
                            @error('fecha_inicio')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Fecha fin --}}
                        <div>
                            <label class="label-pro">Fecha fin</label>
                            <input
                                type="date"
                                name="fecha_fin"
                                class="input-pro-2 mt-1"
                                value="{{ old('fecha_fin') }}"
                            >
                            @error('fecha_fin')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Proveedor/Técnico --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Proveedor / Técnico</label>
                            <input
                                name="proveedor_tecnico"
                                class="input-pro-2 mt-1"
                                value="{{ old('proveedor_tecnico') }}"
                                placeholder="Ej: Taller X / Ing. Juan Pérez"
                            >
                            @error('proveedor_tecnico')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Costo --}}
                        <div>
                            <label class="label-pro">Costo (Bs)</label>
                            <div class="mt-1 relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 text-sm">Bs</span>
                                <input
                                    type="number"
                                    step="0.01"
                                    name="costo"
                                    class="input-pro-2 pl-10"
                                    value="{{ old('costo') }}"
                                    placeholder="0.00"
                                >
                            </div>
                            @error('costo')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="hidden md:block"></div>

                        {{-- Descripción de falla --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Descripción de falla</label>
                            <textarea
                                name="descripcion_falla"
                                class="textarea-pro mt-1"
                                rows="4"
                                placeholder="Describe el problema detectado..."
                            >{{ old('descripcion_falla') }}</textarea>
                            @error('descripcion_falla')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Trabajo realizado --}}
                        <div class="md:col-span-2">
                            <label class="label-pro">Trabajo realizado</label>
                            <textarea
                                name="trabajo_realizado"
                                class="textarea-pro mt-1"
                                rows="4"
                                placeholder="Describe la solución aplicada o acciones realizadas..."
                            >{{ old('trabajo_realizado') }}</textarea>
                            @error('trabajo_realizado')
                                <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                    </div>

                    <div class="pt-5 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                        <div class="text-xs text-gray-500">
                            Tip: agrega costo y técnico para mejorar la auditoría del mantenimiento.
                        </div>

                        <div class="flex gap-2 justify-end">
                            <a href="{{ route('assets.index') }}" class="btn-ghost">
                                Cancelar
                            </a>
                            <button type="submit" class="btn-brand">
                                Guardar Mantenimiento
                            </button>
                        </div>
                    </div>

                </form>
            </div>

        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            if (window.TomSelect) {
                new TomSelect('#asset_id', {
                    create: false,
                    sortField: { field: 'text', direction: 'asc' },
                    maxOptions: 250,
                    placeholder: 'Buscar por código, tipo, marca, responsable, ubicación o serie'
                });
            }
        });
    </script>
</x-app-layout>