<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Activos en Custodia</h2>
                <p class="page-subtitle">Consulta qué activos tiene asignado cada funcionario.</p>
            </div>

            <span class="status-ok">📌 Consulta</span>
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

            {{-- FILTRO / BUSCADOR --}}
            <div class="filters-card mb-6">
                <form method="GET" action="{{ route('custody.index') }}" class="filters-grid">

                    <div class="md:col-span-4">
                        <label class="label-pro">Buscar (nombre / cargo / unidad)</label>
                        <div class="relative mt-1">
                            <span class="absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">🔎</span>
                            <input
                                name="q"
                                value="{{ request('q') }}"
                                class="input-pro-2 pl-9"
                                placeholder="Ej: Juan, Soporte TI, DTI"
                            >
                        </div>
                    </div>

                    <div class="md:col-span-2 flex items-end gap-2">
                        <button class="btn-dark-soft">
                            Filtrar
                        </button>

                        <a href="{{ route('custody.index') }}" class="btn-ghost">
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
                            <div class="section-title">Funcionarios con custodia</div>
                            <div class="section-subtitle">Selecciona “Ver activos” para ver el detalle.</div>
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
                                    <th>Funcionario</th>
                                    <th>Cargo</th>
                                    <th>Unidad</th>
                                    <th>Activos</th>
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
                                            <span class="status-neutral">
                                                {{ $c->activos_en_custodia ?? 0 }}
                                            </span>
                                        </td>

                                        <td class="text-right whitespace-nowrap">
                                            <a href="{{ route('custody.show', $c) }}" class="btn btn-outline btn-sm">
                                                👁 Ver activos
                                            </a>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="py-10 text-center text-gray-500">
                                            No hay funcionarios encontrados con esos filtros.
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