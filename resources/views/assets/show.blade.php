<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Detalle del Activo</h2>
                <p class="page-subtitle">Información general y movimientos registrados.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('assets.index') }}" class="btn-ghost">
                    Volver
                </a>

                @can('assets.edit')
                    <a href="{{ route('assets.edit', $asset) }}" class="btn-warning">
                        Editar
                    </a>
                @endcan

                 @can('assets.view')
        <a href="{{ route('assets.alta.pdf', $asset) }}" class="btn-brand">
            Descargar Acta (PDF)
        </a>
        @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- ✅ Detalle --}}
            <div class="card p-6">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div>
                        <div class="text-gray-500">Código patrimonial</div>
                        <div class="font-semibold text-gray-900">{{ $asset->codigo_patrimonial }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Número de serie</div>
                        <div class="font-semibold text-gray-900">{{ $asset->numero_serie ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Tipo</div>
                        <div class="font-semibold text-gray-900">{{ $asset->type?->name ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Estado</div>
                        <div class="font-semibold text-gray-900">{{ $asset->status?->name ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Ubicación</div>
                        <div class="font-semibold text-gray-900">{{ $asset->location?->name ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Marca</div>
                        <div class="font-semibold text-gray-900">{{ $asset->brand?->name ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Fecha de compra</div>
                        <div class="font-semibold text-gray-900">{{ $asset->fecha_compra ?? '—' }}</div>
                    </div>

                    <div>
                        <div class="text-gray-500">Costo</div>
                        <div class="font-semibold text-gray-900">{{ $asset->costo ?? '—' }}</div>
                    </div>

                    <div class="sm:col-span-2">
                        <div class="text-gray-500">Observaciones</div>
                        <div class="font-semibold text-gray-900">{{ $asset->observaciones ?? '—' }}</div>
                    </div>
                </div>
            </div>

            {{-- ✅ Historial de Movimientos / Asignaciones --}}
            <div class="table-card">
                <div class="p-5 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Historial de movimientos</div>
                        <div class="text-xs text-gray-500">Asignaciones, reasignaciones y traslados del activo.</div>
                    </div>
                    <span class="status-ok">Historial</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        <thead class="table-head">
                            <tr>
                                <th>Fecha</th>
                                <th>Movimiento</th>
                                <th>Custodio</th>
                                <th>Ubicación</th>
                                <th>Observaciones</th>
                                <th class="text-right">Acta</th>
                            </tr>
                        </thead>

                        <tbody>
                            @forelse($movimientos as $m)
                                <tr>
                                    <td class="whitespace-nowrap">{{ $m->fecha_asignacion ?? '—' }}</td>
                                    <td class="whitespace-nowrap">
                                        <span class="status-neutral">{{ $m->tipo_movimiento ?? '—' }}</span>
                                    </td>
                                    <td>{{ $m->custodian?->nombre_completo ?? '—' }}</td>
                                    <td>{{ $m->location?->name ?? '—' }}</td>
                                    <td class="text-gray-700">{{ $m->observaciones ?? '—' }}</td>

                                    <td class="text-right whitespace-nowrap">
    <a href="{{ route('assignments.acta.pdf', $m) }}" class="btn-ghost">
        Descargar Acta PDF
    </a>
</td>
                                    
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                        Este activo todavía no tiene movimientos registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                {{-- Si $movimientos es paginado, puedes activar esto:
                <div class="p-4 sm:p-5 border-t border-gray-200">
                    {{ $movimientos->links() }}
                </div>
                --}}
            </div>

        </div>
    </div>
</x-app-layout>