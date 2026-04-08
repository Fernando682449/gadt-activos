<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Reporte de Altas y Bajas por Fecha</h2>
                <p class="page-subtitle">
                    Consulta los activos dados de alta y de baja dentro de un rango de fechas.
                </p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('assets.index') }}" class="btn-ghost">
                    Volver
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

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

            {{-- Formulario de filtro --}}
            <div class="card p-6">
                <form method="GET" action="{{ route('reports.altas-bajas-fecha') }}" class="grid grid-cols-1 md:grid-cols-3 gap-5 items-end">
                    <div>
                        <label class="label-pro">Fecha inicio</label>
                        <input
                            type="date"
                            name="fecha_inicio"
                            value="{{ request('fecha_inicio') }}"
                            class="input-pro-2 mt-1"
                        >
                    </div>

                    <div>
                        <label class="label-pro">Fecha fin</label>
                        <input
                            type="date"
                            name="fecha_fin"
                            value="{{ request('fecha_fin') }}"
                            class="input-pro-2 mt-1"
                        >
                    </div>

                    <div class="flex gap-2 flex-wrap">
    <button type="submit" class="btn-brand">
        Buscar Reporte
    </button>

    <a href="{{ route('reports.altas-bajas-fecha') }}" class="btn-dark-soft">
        Limpiar
    </a>

    <a href="{{ route('reports.altas-bajas-fecha.pdf', ['fecha_inicio' => request('fecha_inicio'), 'fecha_fin' => request('fecha_fin')]) }}"
       class="btn-ghost">
        Exportar PDF
    </a>
</div>
                </form>
            </div>

            {{-- ALTAS --}}
            <div class="table-card">
                <div class="p-5 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-lg font-semibold text-gray-900">Activos dados de alta</div>
                        <div class="text-sm text-gray-500">
                            Registros creados dentro del rango seleccionado.
                        </div>
                    </div>
                    <span class="status-ok">Altas: {{ $altas->count() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        <thead class="table-head">
                            <tr>
                                <th>Fecha alta</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Ubicación</th>
                                <th>Responsable</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($altas as $asset)
                                <tr>
                                    <td>{{ optional($asset->created_at)->format('Y-m-d') }}</td>
                                    <td>{{ $asset->codigo_patrimonial }}</td>
                                    <td>{{ $asset->type?->name ?? '—' }}</td>
                                    <td>{{ $asset->brand?->name ?? '—' }}</td>
                                    <td>{{ $asset->location?->name ?? '—' }}</td>
                                    <td>
                                        {{ $asset->custodian?->nombre_completo ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? '')) ?: '—' }}
                                    </td>
                                    <td>{{ $asset->status?->name ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                        No hay altas registradas en ese rango de fechas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            {{-- BAJAS --}}
            <div class="table-card">
                <div class="p-5 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-lg font-semibold text-gray-900">Activos dados de baja</div>
                        <div class="text-sm text-gray-500">
                            Activos con fecha de baja dentro del rango seleccionado.
                        </div>
                    </div>
                    <span class="status-bad">Bajas: {{ $bajas->count() }}</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        <thead class="table-head">
                            <tr>
                                <th>Fecha baja</th>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Ubicación</th>
                                <th>Responsable</th>
                                <th>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($bajas as $asset)
                                <tr>
                                    <td>{{ $asset->fecha_baja ?? '—' }}</td>
                                    <td>{{ $asset->codigo_patrimonial }}</td>
                                    <td>{{ $asset->type?->name ?? '—' }}</td>
                                    <td>{{ $asset->brand?->name ?? '—' }}</td>
                                    <td>{{ $asset->location?->name ?? '—' }}</td>
                                    <td>
                                        {{ $asset->custodian?->nombre_completo ?? trim(($asset->custodian->nombres ?? '') . ' ' . ($asset->custodian->apellidos ?? '')) ?: '—' }}
                                    </td>
                                    <td>{{ $asset->status?->name ?? '—' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="px-4 py-10 text-center text-gray-500">
                                        No hay bajas registradas en ese rango de fechas.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>