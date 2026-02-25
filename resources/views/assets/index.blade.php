<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Activos
            </h2>

            <a href="{{ route('assets.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Nuevo Activo
            </a>
            <a href="{{ route('reports.assets.pdf', request()->query()) }}"
   class="px-4 py-2 bg-gray-900 text-white rounded hover:bg-black">
    Exportar PDF
</a>
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="mb-4 p-3 rounded bg-green-50 text-green-800 border border-green-200">
                    {{ session('success') }}
                </div>
            @endif

            <!-- FILTROS -->
            <div class="bg-white p-4 rounded shadow-sm mb-4">
                <form method="GET" action="{{ route('assets.index') }}" class="grid grid-cols-1 md:grid-cols-6 gap-3">

                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600">Buscar (Código / Serie)</label>
                        <input name="q" value="{{ request('q') }}"
                               class="w-full border rounded p-2"
                               placeholder="Ej: GADT-0001 o SN123">
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Tipo</label>
                        <select name="asset_type_id" class="w-full border rounded p-2">
                            <option value="">Todos</option>
                            @foreach($types as $t)
                                <option value="{{ $t->id }}" @selected(request('asset_type_id') == $t->id)>
                                    {{ $t->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Estado</label>
                        <select name="status_id" class="w-full border rounded p-2">
                            <option value="">Todos</option>
                            @foreach($statuses as $s)
                                <option value="{{ $s->id }}" @selected(request('status_id') == $s->id)>
                                    {{ $s->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Ubicación</label>
                        <select name="location_id" class="w-full border rounded p-2">
                            <option value="">Todas</option>
                            @foreach($locations as $l)
                                <option value="{{ $l->id }}" @selected(request('location_id') == $l->id)>
                                    {{ $l->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="text-sm text-gray-600">Marca</label>
                        <select name="brand_id" class="w-full border rounded p-2">
                            <option value="">Todas</option>
                            @foreach($brands as $b)
                                <option value="{{ $b->id }}" @selected(request('brand_id') == $b->id)>
                                    {{ $b->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="md:col-span-6 flex gap-2">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded">
                            Filtrar
                        </button>

                        <a href="{{ route('assets.index') }}"
                           class="px-4 py-2 border rounded">
                            Limpiar
                        </a>
                    </div>
                </form>
            </div>

            <!-- TABLA -->
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <table class="w-full text-sm">
                        <thead>
                        <tr class="border-b">
                            <th class="text-left py-2">Código</th>
                            <th class="text-left py-2">Tipo</th>
                            <th class="text-left py-2">Estado</th>
                            <th class="text-left py-2">Ubicación</th>
                            <th class="text-left py-2">Marca</th>
                            <th class="text-right py-2">Acciones</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($assets as $asset)
                            <tr class="border-b">
                                <td class="py-2">{{ $asset->codigo_patrimonial }}</td>
                                <td class="py-2">{{ $asset->type?->name ?? '—' }}</td>
                                <td class="py-2">{{ $asset->status?->name ?? '—' }}</td>
                                <td class="py-2">{{ $asset->location?->name ?? '—' }}</td>
                                <td class="py-2">{{ $asset->brand?->name ?? '—' }}</td>
                                <td class="py-2 text-right">
                                    <a class="text-blue-700" href="{{ route('assets.show', $asset) }}">Ver</a>
                                    <span class="text-gray-400">|</span>
                                    <a class="text-yellow-700" href="{{ route('assets.edit', $asset) }}">Editar</a>
                                    <span class="text-gray-400">|</span>

                                    <form action="{{ route('assets.destroy', $asset) }}" method="POST" class="inline"
                                          onsubmit="return confirm('¿Dar de baja este activo?');">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600">Baja</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-6 text-center text-gray-500">
                                    No hay activos con esos filtros.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $assets->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>