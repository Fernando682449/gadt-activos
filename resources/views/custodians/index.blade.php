<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Custodios
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                    {{ session('success') }}
                </div>
            @endif

            <div class="mb-4">
                <a href="{{ route('custodians.create') }}"
                   class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                    + Nuevo Custodio
                </a>
            </div>

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
                            @foreach ($custodians as $c)
                                <tr class="border-b">
                                    <td class="py-2">{{ $c->nombre_completo }}</td>
                                    <td class="py-2">{{ $c->cargo ?? '—' }}</td>
                                    <td class="py-2">{{ $c->unidad ?? '—' }}</td>
                                    <td class="py-2">
                                        @if($c->activo)
                                            <span class="text-green-700">Activo</span>
                                        @else
                                            <span class="text-red-700">Inactivo</span>
                                        @endif
                                    </td>
                                    <td class="py-2 text-right">
                                        <a class="text-blue-600" href="{{ route('custodians.show', $c) }}">Ver</a>
                                        |
                                        <a class="text-yellow-600" href="{{ route('custodians.edit', $c) }}">Editar</a>

                                        @if($c->activo)
                                            |
                                            <form class="inline" method="POST" action="{{ route('custodians.destroy', $c) }}"
                                                  onsubmit="return confirm('¿Desactivar este custodio?');">
                                                @csrf
                                                @method('DELETE')
                                                <button class="text-red-600" type="submit">Desactivar</button>
                                            </form>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
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
