<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Custodios
            </h2>

            <a href="{{ route('custodians.create') }}"
               class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                + Nuevo Custodio
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
                <form method="GET" action="{{ route('custodians.index') }}"
                      class="grid grid-cols-1 md:grid-cols-5 gap-3">

                    <div class="md:col-span-3">
                        <label class="text-sm text-gray-600">Buscar (nombre / cargo / unidad)</label>
                        <input name="q" value="{{ request('q') }}"
                               class="w-full border rounded p-2"
                               placeholder="Ej: Juan, Soporte TI, DTI">
                    </div>

                    <div class="md:col-span-2">
                        <label class="text-sm text-gray-600">Estado</label>
                        <select name="activo" class="w-full border rounded p-2">
                            <option value="">Todos</option>
                            <option value="1" @selected(request('activo') === '1')>Activos</option>
                            <option value="0" @selected(request('activo') === '0')>Inactivos</option>
                        </select>
                    </div>

                    <div class="md:col-span-5 flex gap-2">
                        <button class="px-4 py-2 bg-gray-900 text-white rounded">
                            Filtrar
                        </button>

                        <a href="{{ route('custodians.index') }}" class="px-4 py-2 border rounded">
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
                            <th class="text-left py-2">Nombre</th>
                            <th class="text-left py-2">Cargo</th>
                            <th class="text-left py-2">Unidad</th>
                            <th class="text-left py-2">Estado</th>
                            <th class="text-right py-2">Acciones</th>
                        </tr>
                        </thead>

                        <tbody>
                        @forelse($custodians as $c)
                            <tr class="border-b">
                                <td class="py-2">
                                    {{ $c->nombres }} {{ $c->apellidos }}
                                </td>
                                <td class="py-2">{{ $c->cargo ?? '—' }}</td>
                                <td class="py-2">{{ $c->unidad ?? '—' }}</td>
                                <td class="py-2">
                                    @if($c->activo)
                                        <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-800">
                                            Activo
                                        </span>
                                    @else
                                        <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                                <td class="py-2 text-right">
                                    <a class="text-blue-700" href="{{ route('custodians.show', $c) }}">Ver</a>
                                    <span class="text-gray-400">|</span>
                                    <a class="text-yellow-700" href="{{ route('custodians.edit', $c) }}">Editar</a>
                                    <span class="text-gray-400">|</span>

                                    @if($c->activo)
                                        <form action="{{ route('custodians.destroy', $c) }}" method="POST" class="inline"
                                              onsubmit="return confirm('¿Desactivar este custodio?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600">Desactivar</button>
                                        </form>
                                    @else
                                        <span class="text-gray-400">—</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-6 text-center text-gray-500">
                                    No hay custodios con esos filtros.
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>

                    <div class="mt-4">
                        {{ $custodians->links() }}
                    </div>

                </div>
            </div>

        </div>
    </div>
</x-app-layout>
