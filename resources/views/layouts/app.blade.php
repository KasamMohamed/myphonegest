<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>MyPhoneGest - Terminal</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,700,900&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Force l'application à utiliser la police Inter (très tech/pro) */
        body {
            font-family: 'Inter', sans-serif;
        }
    </style>
</head>
<body class="font-sans text-gray-900 antialiased bg-gray-50 selection:bg-sky-500 selection:text-white">
<div class="min-h-screen">

    <nav class="bg-black border-b-4 border-sky-500">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between h-16">
                <div class="flex items-center">

                    <div class="shrink-0 flex items-center">
                        <a href="{{ route('dashboard') }}" class="text-2xl font-black text-white tracking-widest uppercase">
                            MYPHONE<span class="text-sky-500">GEST</span>
                        </a>
                    </div>

                    <div class="hidden space-x-1 sm:-my-px sm:ms-10 sm:flex">
                        <a href="{{ route('dashboard') }}" class="inline-flex items-center px-4 pt-1 font-bold text-xs uppercase tracking-widest text-white hover:text-sky-400 transition-colors {{ request()->routeIs('dashboard') ? 'text-sky-500 border-b-2 border-sky-500' : '' }}">
                            Atelier
                        </a>
                        <a href="{{ route('pieces.index') }}" class="inline-flex items-center px-4 pt-1 font-bold text-xs uppercase tracking-widest text-white hover:text-sky-400 transition-colors {{ request()->routeIs('pieces.*') ? 'text-sky-500 border-b-2 border-sky-500' : '' }}">
                            Inventaire
                        </a>
                        <a href="{{ route('caisse.index') }}" class="inline-flex items-center px-4 pt-1 font-bold text-xs uppercase tracking-widest text-white hover:text-sky-400 transition-colors {{ request()->routeIs('caisse.*') ? 'text-sky-500 border-b-2 border-sky-500' : '' }}">
                            Caisse Rapide
                        </a>
                        <a href="{{ route('depenses.index') }}" class="inline-flex items-center px-4 pt-1 font-bold text-xs uppercase tracking-widest text-white hover:text-sky-400 transition-colors {{ request()->routeIs('depenses.*') ? 'text-sky-500 border-b-2 border-sky-500' : '' }}">
                            Dépenses
                        </a>
                    </div>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-xs font-bold text-gray-400 uppercase tracking-widest hover:text-white transition">
                            Déconnexion
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    @isset($header)
        <header class="bg-white border-b border-gray-200">
            <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                {{ $header }}
            </div>
        </header>
    @endisset

    <main>
        {{ $slot }}
    </main>

</div>
</body>
</html>
