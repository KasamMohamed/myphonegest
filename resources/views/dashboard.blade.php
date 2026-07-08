<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
            Tableau de bord & Comptabilité
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-black font-semibold rounded-none bg-sky-100 border-l-4 border-sky-500 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-4 gap-6">
                <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-sky-500 hover:shadow-md transition-shadow">
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">CA Total</p>
                    <p class="text-3xl font-black text-black mt-2">{{ number_format($totalCA, 2, ',', ' ') }} €</p>
                </div>

                <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-black hover:shadow-md transition-shadow">
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Achats Pièces</p>
                    <p class="text-3xl font-black text-black mt-2">- {{ number_format($coutPieces, 2, ',', ' ') }} €</p>
                </div>

                <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-gray-400 hover:shadow-md transition-shadow">
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Charges & Dépenses</p>
                    <p class="text-3xl font-black text-gray-700 mt-2">- {{ number_format($totalDepenses, 2, ',', ' ') }} €</p>
                </div>

                <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-sky-300 hover:shadow-md transition-shadow">
                    <p class="text-xs text-gray-500 uppercase font-bold tracking-wider">Bénéfice Net</p>
                    <p class="text-3xl font-black text-sky-500 mt-2">{{ number_format($beneficeNet, 2, ',', ' ') }} €</p>
                </div>
            </div>

            <div class="bg-white overflow-hidden shadow-sm border border-gray-100">

                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                    <h3 class="text-lg font-black text-black uppercase tracking-wide">Réparations en cours</h3>

                    <div class="flex gap-3">
                        <a href="{{ route('reparations.index') }}" class="inline-flex items-center px-4 py-2 bg-black border border-transparent font-black text-xs text-white uppercase tracking-widest hover:bg-gray-800 transition shadow-sm">
                            Historique complet
                        </a>
                        <a href="{{ route('reparations.create') }}" class="inline-flex items-center px-4 py-2 bg-sky-500 border border-transparent font-black text-xs text-white uppercase tracking-widest hover:bg-sky-600 transition shadow-sm">
                            + Nouveau Ticket
                        </a>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-black">
                        <tr>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Date</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Client</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Appareil</th>
                            <th scope="col" class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wider">Statut</th>
                            <th scope="col" class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wider">Action</th>
                        </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-100">
                        @forelse ($reparations as $rep)
                            <tr class="hover:bg-sky-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($rep->date_depot)->format('d/m/Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="font-black text-black">{{ $rep->client_nom }}</div>
                                    <div class="text-xs text-sky-600 font-bold">{{ $rep->client_telephone }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-bold text-black">{{ $rep->appareil_marque }}</div>
                                    <div class="text-sm text-gray-500">{{ $rep->appareil_modele }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-none text-xs font-bold bg-sky-100 text-sky-700 border border-sky-200">
                                            {{ $rep->statut }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <a href="{{ route('reparations.show', $rep->id) }}" class="text-black hover:text-sky-500 font-black flex justify-end items-center gap-1 transition-colors">
                                        Ouvrir
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center">
                                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 002-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                                    </svg>
                                    <h3 class="mt-2 text-sm font-bold text-black">Aucune réparation en cours</h3>
                                    <p class="mt-1 text-sm text-gray-500">L'atelier est vide pour le moment.</p>
                                </td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
