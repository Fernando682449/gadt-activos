<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Activos</h2>
                <p class="page-subtitle">Listado, filtros y acciones rápidas</p>
            </div>

            <div class="flex flex-wrap gap-2">
                @can('assets.create')
                    <a href="{{ route('assets.create') }}" class="btn-brand">
                        + Nuevo Activo
                    </a>
                @endcan

                @can('reports.export')
                    <a href="{{ route('reports.assets.pdf') }}" class="btn-dark-soft">
                        Exportar PDF
                    </a>
                @endcan
            </div>
            
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="alert-success mb-5">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FILTROS --}}
            <div class="filters-card mb-6">
                <form method="GET" action="{{ route('assets.index') }}" class="filters-grid">

                    <div class="md:col-span-2">
                        <label class="label-pro">Buscar (Código / Serie)</label>
                        <input name="q" value="{{ request('q') }}"
                               class="input-pro-2"
                               placeholder="Ej: GADT-0001 o SN123">
                    </div>

                    <div>
                        <label class="label-pro">Tipo</label>
                        <select name="asset_type_id" class="select-pro-2">
                            <option value="">Todos</option>
                            @foreach($types as $t)
                                <option value="{{ $t->id }}" @selected(request('asset_type_id') == $t->id)>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="label-pro">Estado</label>
                        <select name="status_id" class="select-pro-2">
                            <option value="">Todos</option>
                            @foreach($statuses as $s)
                                <option value="{{ $s->id }}" @selected(request('status_id') == $s->id)>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="label-pro">Ubicación</label>
                        <select name="location_id" class="select-pro-2">
                            <option value="">Todas</option>
                            @foreach($locations as $l)
                                <option value="{{ $l->id }}" @selected(request('location_id') == $l->id)>
                                    {{ $l->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Si ya estás usando marcas en el filtro --}}
                    @isset($brands)
                        <div>
                            <label class="label-pro">Marca</label>
                            <select name="brand_id" class="select-pro-2">
                                <option value="">Todas</option>
                                @foreach($brands as $b)
                                    <option value="{{ $b->id }}" @selected(request('brand_id') == $b->id)>
                                        {{ $b->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    @endisset

                    <div class="filters-actions">
                        <button class="btn-dark">
                            Filtrar
                        </button>

                        <a href="{{ route('assets.index') }}" class="btn-ghost">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            {{-- TABLA --}}
            <div class="table-card">
                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        <thead class="table-head">
                        <tr>
                            <th>Código</th>
                            <th>Tipo</th>
                            <th>Estado</th>
                            <th>Ubicación</th>
                            <th>Marca</th>
                            <th class="text-right">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($assets as $asset)
                            <tr>
                                <td class="font-semibold text-gray-900">{{ $asset->codigo_patrimonial }}</td>
                                <td>{{ $asset->type?->name ?? '—' }}</td>

                                {{-- Estado en pill --}}
                                <td>
                                    @php
                                        $st = strtolower($asset->status?->name ?? '');
                                    @endphp

                                    @if(str_contains($st, 'activo'))
                                        <span class="status-ok">{{ $asset->status?->name }}</span>
                                    @elseif(str_contains($st, 'repar'))
                                        <span class="status-warn">{{ $asset->status?->name }}</span>
                                    @elseif(str_contains($st, 'baja'))
                                        <span class="status-bad">{{ $asset->status?->name }}</span>
                                    @else
                                        <span class="status-neutral">{{ $asset->status?->name ?? '—' }}</span>
                                    @endif
                                </td>

                                <td>{{ $asset->location?->name ?? '—' }}</td>
                                <td>{{ $asset->brand?->name ?? '—' }}</td>

                                <td class="text-right table-actions">
                                    <a class="link-view" href="{{ route('assets.show', $asset) }}">Ver</a>
                                    <span class="text-gray-300 px-1">|</span>

                                    @can('assets.edit')
                                        <a class="link-edit" href="{{ route('assets.edit', $asset) }}">Editar</a>
                                        <span class="text-gray-300 px-1">|</span>
                                    @endcan

                                    @can('assets.delete')
                                        <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Dar de baja este activo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="link-delete">Baja</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-4 py-10 text-center text-gray-500">
                                    No hay activos con esos filtros.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-4">
                    {{ $assets->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>