<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Efectos en Custodia</h2>
                <p class="page-subtitle">
                    Funcionario: <span class="font-semibold text-gray-800">{{ $custodian->nombre_completo }}</span>
                    <span class="text-gray-400">•</span>
                    {{ $custodian->cargo ?? '—' }}
                    <span class="text-gray-400">•</span>
                    {{ $custodian->unidad ?? '—' }}
                </p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('custody.index') }}" class="btn-ghost">
                    ← Volver
                </a>

                <a href="{{ route('custodians.show', $custodian) }}" class="btn-outline">
                    👤 Ver custodio
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Resumen --}}
            <div class="card p-6">
                <div class="grid grid-cols-1 sm:grid-cols-4 gap-4">
                    <div>
                        <div class="text-sm text-gray-500">Total activos</div>
                        <div class="text-3xl font-extrabold text-gray-900">{{ $assets->count() }}</div>
                    </div>
                    <div class="sm:col-span-3">
                        <div class="text-sm text-gray-500">Email</div>
                        <div class="font-semibold text-gray-900">{{ $custodian->email ?? '—' }}</div>
                    </div>
                </div>
            </div>

            {{-- Tabla de activos --}}
            <div class="table-card">
                <div class="p-5 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Listado de activos asignados</div>
                        <div class="text-xs text-gray-500">
                            Antes de devolver un activo, verifique claramente a quién fue entregado y la fecha de asignación.
                        </div>
                    </div>

                    <span class="status-ok">📦 Activos en Custodia</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        <thead class="table-head">
                            <tr>
                                <th>Código</th>
                                <th>Tipo</th>
                                <th>Marca</th>
                                <th>Ubicación</th>
                                <th>Estado</th>
                                <th>Entregado a / Responsable actual</th>
                                <th>Fecha de entrega</th>
                                <th class="text-right">Acciones</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($assets as $a)
                                <tr>
                                    <td class="font-medium text-gray-900">
                                        <div>{{ $a->codigo_patrimonial }}</div>
                                        <div class="text-xs text-gray-500">
                                            {{ $a->observaciones ?: ($a->type?->name ?? 'Sin descripción') }}
                                        </div>
                                    </td>

                                    <td>{{ $a->type?->name ?? '—' }}</td>
                                    <td>{{ $a->brand?->name ?? '—' }}</td>
                                    <td>{{ $a->location?->name ?? '—' }}</td>

                                    <td>
                                        @php
                                            $st = strtolower($a->status?->name ?? '');
                                        @endphp

                                        @if(str_contains($st, 'activo'))
                                            <span class="status-ok">{{ $a->status?->name }}</span>
                                        @elseif(str_contains($st, 'repar'))
                                            <span class="status-warn">{{ $a->status?->name }}</span>
                                        @elseif(str_contains($st, 'baja'))
                                            <span class="status-bad">{{ $a->status?->name }}</span>
                                        @else
                                            <span class="status-neutral">{{ $a->status?->name ?? '—' }}</span>
                                        @endif
                                    </td>

                                    <td>
                                        {{ $a->custodian?->nombre_completo ?? trim(($a->custodian->nombres ?? '') . ' ' . ($a->custodian->apellidos ?? '')) ?: '—' }}
                                    </td>

                                    <td class="whitespace-nowrap">
                                        {{ $a->lastAssignmentEntrega?->fecha_asignacion ?? $a->lastAssignment?->fecha_asignacion ?? '—' }}
                                    </td>

                                    <td class="text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2 flex-wrap">

                                            <a href="{{ route('assets.show', $a) }}" class="btn btn-outline btn-sm">
                                                👁 Ver
                                            </a>

                                            @if(optional($a->lastAssignment)->acta_pdf_path)
                                                <a href="{{ route('assignments.acta', $a->lastAssignment) }}"
                                                   class="btn btn-outline btn-sm">
                                                    📄 Acta PDF
                                                </a>
                                            @endif

                                            @can('assignments.create')
                                                <form method="POST"
                                                      action="{{ route('custody.devolver', [$custodian, $a]) }}"
                                                      class="inline-flex gap-2 items-center">
                                                    @csrf

                                                    <select name="location_id" class="select-pro-2" required>
                                                        <option value="">Ubicación devolución</option>
                                                        @foreach(\App\Models\Location::orderBy('name')->get() as $loc)
                                                            <option value="{{ $loc->id }}">{{ $loc->name }}</option>
                                                        @endforeach
                                                    </select>

                                                    <button class="btn btn-danger btn-sm"
                                                            onclick="return confirm('¿Confirmar devolución de este activo?')">
                                                        ↩ Devolver
                                                    </button>
                                                </form>
                                            @endcan

                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="py-10 text-center text-gray-500">
                                        Este funcionario no tiene activos asignados actualmente.
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