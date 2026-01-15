<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Activos
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
                <a href="{{ route('assets.create') }}"
                   class="px-4 py-2 bg-blue-600 text-white rounded">
                    + Nuevo Activo
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6">

                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b">
                                <th class="text-left py-2">Código</th>
                                <th class="text-left py-2">Tipo</th>
                                <th class="text-left py-2">Estado</th>
                                <th class="text-left py-2">Ubicación</th>
                                <th class="text-right py-2">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($assets as $asset)
                                <tr class="border-b">
                                    <td class="py-2">{{ $asset->codigo_patrimonial }}</td>
                                    <td class="py-2">{{ $asset->type?->name }}</td>
                                    <td class="py-2">{{ $asset->status?->name }}</td>
                                    <td class="py-2">{{ $asset->location?->name }}</td>
                                    <td class="py-2 text-right">
                                        <a class="text-blue-600" href="{{ route('assets.show', $asset) }}">Ver</a>
                                        |
                                        <a class="text-yellow-600" href="{{ route('assets.edit', $asset) }}">Editar</a>
                                        |
                                        <form class="inline" method="POST" action="{{ route('assets.destroy', $asset) }}"
                                              onsubmit="return confirm('¿Dar de baja este activo?');">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600" type="submit">Baja</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
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
