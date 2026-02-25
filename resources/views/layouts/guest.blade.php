<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">

    {{-- Fondo --}}
    <div class="min-h-screen relative"
         style="background-image: url('{{ asset('img/1.jpg') }}'); background-size: cover; background-position: center;">
        {{-- overlay --}}
        <div class="absolute inset-0 bg-white/70"></div>

        <div class="relative min-h-screen">

            {{-- Encabezado arriba-izquierda (opcional, puedes quitarlo si ya lo tendrás en el login) --}}
            <header class="absolute top-0 left-0 w-full z-10">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">
                    <div class="flex items-center gap-3">
                        <img src="{{ asset('img/2.jpg') }}"
                             class="h-12 w-12 object-contain rounded bg-white/80 p-1"
                             alt="Logo">
                        <div class="leading-tight">
                            <div class="text-lg sm:text-xl font-bold text-gray-900">GADT - Tarija</div>
                            <div class="text-xs sm:text-sm text-gray-600">Sistema de Gestión de Activos</div>
                        </div>
                    </div>
                </div>
            </header>

            {{-- ✅ Contenedor centrado: Login + tarjeta debajo --}}
            <main class="min-h-screen flex items-center justify-center px-4">
                <div class="w-full max-w-md flex flex-col gap-6">

                    {{-- Login --}}
                    <div>
                        {{ $slot }}
                    </div>

                    

                        <div class="mt-4 text-center text-xs text-gray-500">
                            © {{ now()->year }} Gobierno Autónomo Departamental de Tarija
                        </div>
                    </div>

                </div>
            </main>

        </div>
    </div>

</body>
</html>