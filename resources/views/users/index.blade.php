<x-app-layout>
    <x-slot name="header">
        <div class="page-header">
            <div>
                <h2 class="page-title">Usuarios</h2>
                <p class="page-subtitle">Listado general de usuarios registrados en el sistema.</p>
            </div>

            <div class="flex gap-2">
                <a href="{{ route('users.create') }}" class="btn-brand">
                    + Nuevo Usuario
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-8 page-bg">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">

            @if(session('success'))
                <div class="alert-success mb-6">
                    {{ session('success') }}
                </div>
            @endif

            <div class="table-card">
                <div class="overflow-x-auto">
                    <table class="table-pro-2">
                        <thead class="table-head">
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Rol</th>
                                <th>Fecha de creación</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($users as $user)
                                <tr>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->roles->pluck('name')->implode(', ') ?: 'Sin rol' }}</td>
                                    <td>{{ optional($user->created_at)->format('Y-m-d H:i') }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-4 py-10 text-center text-gray-500">
                                        No hay usuarios registrados.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="px-4 py-4">
                    {{ $users->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>