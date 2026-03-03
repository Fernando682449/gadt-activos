<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Custodios</h2>
                <p class="page-subtitle">Administración de responsables de activos</p>
            </div>

            @can('custodians.create')
                <a href="{{ route('custodians.create') }}" class="btn-brand">
                    <span class="text-lg leading-none">+</span>
                    Nuevo Custodio
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- ALERTA --}}
            @if(session('success'))
                <div class="alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FILTROS --}}
            <div class="filters-card mb-6">
                <form method="GET" action="{{ route('custodians.index') }}" class="filters-grid">

                    {{-- Buscar --}}
                    <div class="md:col-span-4">
                        <label class="label-pro">Buscar (nombre / cargo / unidad)</label>
                        <div class="relative mt-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">
                                🔎
                            </span>
                            <input
                                name="q"
                                value="{{ request('q') }}"
                                class="input-pro-2 pl-9"
                                placeholder="Ej: Juan, Soporte TI, DTI"
                            >
                        </div>
                    </div>

                    {{-- Estado --}}
                    <div class="md:col-span-2">
                        <label class="label-pro">Estado</label>
                        <select name="activo" class="select-pro-2 mt-1">
                            <option value="">Todos</option>
                            <option value="1" @selected(request('activo') === '1')>Activos</option>
                            <option value="0" @selected(request('activo') === '0')>Inactivos</option>
                        </select>
                    </div>

                    {{-- Botones --}}
                    <div class="filters-actions mt-1">
                        <button class="btn-dark-soft">
                            Filtrar
                        </button>

                        <a href="{{ route('custodians.index') }}" class="btn-ghost">
                            Limpiar
                        </a>
                    </div>

                </form>
            </div>

            {{-- TABLA --}}
            <div class="table-card">
                <div class="p-6">

                    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-4">
                        <div>
                            <div class="section-title">Listado de Custodios</div>
                            <div class="section-subtitle">Resultados según filtros aplicados</div>
                        </div>

                        <div class="text-sm text-gray-500">
                            Mostrando <span class="font-semibold text-gray-800">{{ $custodians->count() }}</span>
                            de <span class="font-semibold text-gray-800">{{ $custodians->total() }}</span> registros
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="table-pro-2">
                            <thead class="table-head">
                                <tr>
                                    <th>Nombre</th>
                                    <th>Cargo</th>
                                    <th>Unidad</th>
                                    <th>Estado</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>

                            <tbody>
                                @forelse($custodians as $c)
                                    <tr>
                                        <td class="font-medium text-gray-900">
                                            {{ $c->nombres }} {{ $c->apellidos }}
                                        </td>

                                        <td>{{ $c->cargo ?? '—' }}</td>
                                        <td>{{ $c->unidad ?? '—' }}</td>

                                        <td>
                                            @if($c->activo)
                                                <span class="status-ok">
                                                    <span class="mr-1">✅</span> Activo
                                                </span>
                                            @else
                                                <span class="status-neutral">
                                                    <span class="mr-1">⛔</span> Inactivo
                                                </span>
                                            @endif
                                        </td>

                                        {{-- ACCIONES CON BOTONES --}}
                                        <td class="text-right whitespace-nowrap">
                                            <div class="inline-flex items-center gap-2">

                                                <a href="{{ route('custodians.show', $c) }}"
                                                   class="btn btn-outline btn-sm">
                                                    👁 Ver
                                                </a>

                                                <a href="{{ route('custodians.edit', $c) }}"
                                                   class="btn btn-warning btn-sm">
                                                    ✏️ Editar
                                                </a>

                                                @if($c->activo)
                                                    <form action="{{ route('custodians.destroy', $c) }}" method="POST" class="inline"
                                                          onsubmit="return confirm('¿Desactivar este custodio?');">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm">
                                                            ⛔ Desactivar
                                                        </button>
                                                    </form>
                                                @else
                                                    <span class="text-gray-400 text-sm">—</span>
                                                @endif

                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-gray-500">
                                            No hay custodios con esos filtros.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-5">
                        {{ $custodians->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>