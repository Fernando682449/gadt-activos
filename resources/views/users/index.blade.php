<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">Usuarios</h2>
</x-slot>

<div class="py-8">
<div class="max-w-4xl mx-auto bg-white p-6 rounded shadow">

<a href="{{ route('users.create') }}" class="bg-green-600 text-white px-3 py-2 rounded">
+ Nuevo Usuario
</a>

<table class="w-full mt-4 border">
<tr class="bg-gray-100">
<th>Nombre</th>
<th>Email</th>
<th>Rol</th>
</tr>

@foreach($users as $user)
<tr>
<td>{{ $user->name }}</td>
<td>{{ $user->email }}</td>
<td>{{ $user->roles->first()?->name }}</td>
</tr>
@endforeach

</table>

</div>
</div>
</x-app-layout>