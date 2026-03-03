<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Marcas</h2>
                <p class="page-subtitle">Catálogo de marcas disponibles para registrar activos.</p>
            </div>

            @can('brands.create')
                <a href="{{ route('brands.create') }}" class="btn-brand">
                    + Nueva marca
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="alert-success mb-5">
                    {{ session('success') }}
                </div>
            @endif

            {{-- Filtros --}}
            <div class="filters-card mb-6">
                <form method="GET" action="{{ route('brands.index') }}" class="filters-grid">
                    <div class="md:col-span-4">
                        <label class="label-pro">Buscar (nombre)</label>
                        <input
                            name="q"
                            value="{{ request('q') }}"
                            class="input-pro-2"
                            placeholder="Ej: HP, Lenovo, Dell"
                        >
                    </div>

                    <div class="md:col-span-2 flex items-end gap-2">
                        <button type="submit" class="btn-dark-soft">Filtrar</button>
                        <a href="{{ route('brands.index') }}" class="btn-ghost">Limpiar</a>
                    </div>
                </form>
            </div>

            {{-- Tabla --}}
            <div class="table-card">
                <div class="p-5 border-b border-gray-200 flex items-center justify-between">
                    <div>
                        <div class="text-sm text-gray-600">Total</div>
                        <div class="text-2xl font-extrabold text-gray-900">
                            {{ $brands->total() }}
                        </div>
                    </div>

                    <span class="status-ok">Catálogo</span>
                </div>

                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        

                        <tbody>
                            @forelse($brands as $b)
                                <tr>
                                    <td class="font-medium text-gray-900">
                                        {{ $b->name }}
                                    </td>

                                    <td class="text-right whitespace-nowrap">
                                        <div class="inline-flex items-center gap-2 justify-end">
                                            @can('brands.edit')
                                                <a href="{{ route('brands.edit', $b) }}"
                                                   class="btn btn-outline">
                                                    Editar
                                                </a>
                                            @endcan

                                            @can('brands.delete')
                                                <form action="{{ route('brands.destroy', $b) }}"
                                                      method="POST"
                                                      onsubmit="return confirm('¿Eliminar esta marca?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger">
                                                        Eliminar
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="2" class="px-4 py-10 text-center text-gray-500">
                                        No hay marcas registradas todavía.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="p-4 sm:p-5 border-t border-gray-200">
                    {{ $brands->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>