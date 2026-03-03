<x-app-layout>
<x-slot name="header">
    <h2 class="text-xl font-bold">Crear Usuario</h2>
</x-slot>

<div class="py-8">
<div class="max-w-2xl mx-auto bg-white p-6 rounded shadow">

<form method="POST" action="{{ route('users.store') }}">
@csrf

<div class="mb-4">
<label>Nombre</label>
<input type="text" name="name" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label>Email</label>
<input type="email" name="email" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label>Contraseña</label>
<input type="password" name="password" class="w-full border rounded p-2">
</div>

<div class="mb-4">
<label>Rol</label>
<select name="role" class="w-full border rounded p-2">
@foreach($roles as $role)
<option value="{{ $role->name }}">{{ $role->name }}</option>
@endforeach
</select>
</div>

<button class="bg-blue-600 text-white px-4 py-2 rounded">
Crear Usuario
</button>

</form>

</div>
</div>
</x-app-layout>