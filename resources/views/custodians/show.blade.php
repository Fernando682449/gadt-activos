<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Detalle del Custodio</h2>
                <p class="page-subtitle">Información del funcionario responsable de activos.</p>
            </div>

            <div class="flex flex-wrap gap-2">
                <a href="{{ route('custodians.index') }}" class="btn-ghost">
                    ← Volver
                </a>

                @can('custodians.edit')
                    <a href="{{ route('custodians.edit', $custodian) }}" class="btn-warning">
                        ✏️ Editar
                    </a>
                @endcan

                {{-- acceso directo a Custodia (activos asignados) --}}
                <a href="{{ route('custody.show', $custodian) }}" class="btn-outline">
                    📦 Ver activos en custodia
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-10 page-bg">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Tarjeta principal --}}
            <div class="card p-6 sm:p-8">
                <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-6">

                    <div class="flex items-start gap-4">
                        {{-- Avatar --}}
                        <div class="h-12 w-12 rounded-2xl bg-gray-100 flex items-center justify-center text-xl">
                            👤
                        </div>

                        <div>
                            <div class="text-xs text-gray-500 mb-1">Funcionario</div>
                            <div class="text-2xl font-extrabold text-gray-900 leading-tight">
                                {{ $custodian->nombre_completo }}
                            </div>

                            <div class="mt-2 flex flex-wrap gap-2">
                                @if($custodian->activo)
                                    <span class="status-ok">✅ Activo</span>
                                @else
                                    <span class="status-neutral">⛔ Inactivo</span>
                                @endif

                                @if($custodian->cargo)
                                    <span class="status-pill bg-gray-100 text-gray-800">💼 {{ $custodian->cargo }}</span>
                                @endif

                                @if($custodian->unidad)
                                    <span class="status-pill bg-gray-100 text-gray-800">🏢 {{ $custodian->unidad }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Mini resumen --}}
                    <div class="w-full sm:w-auto">
                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                            <div class="text-xs text-gray-500">Contacto</div>
                            <div class="mt-1 text-sm font-semibold text-gray-900">
                                {{ $custodian->email ?? '—' }}
                            </div>
                        </div>
                    </div>

                </div>

                {{-- Detalles en grid --}}
                <div class="mt-8 grid grid-cols-1 sm:grid-cols-2 gap-4 text-sm">
                    <div class="rounded-xl border border-gray-200 p-4">
                        <div class="text-gray-500">Cargo</div>
                        <div class="font-semibold text-gray-900">{{ $custodian->cargo ?? '—' }}</div>
                    </div>

                    <div class="rounded-xl border border-gray-200 p-4">
                        <div class="text-gray-500">Unidad</div>
                        <div class="font-semibold text-gray-900">{{ $custodian->unidad ?? '—' }}</div>
                    </div>

                    <div class="rounded-xl border border-gray-200 p-4 sm:col-span-2">
                        <div class="text-gray-500">Email</div>
                        <div class="font-semibold text-gray-900 break-all">{{ $custodian->email ?? '—' }}</div>
                    </div>
                </div>

                {{-- Acciones abajo (opcional, más bonito) --}}
                <div class="mt-8 pt-6 border-t border-gray-200 flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3">
                    <div class="text-xs text-gray-500">
                        Este registro identifica al custodio y su información administrativa.
                    </div>

                    <div class="flex gap-2 justify-end">
                        <a href="{{ route('custodians.index') }}" class="btn-ghost">
                            Volver
                        </a>

                        @can('custodians.edit')
                            <a href="{{ route('custodians.edit', $custodian) }}" class="btn-warning">
                                Editar
                            </a>
                        @endcan
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>