<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
                Historique de tous les tickets
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-black transition">
                &larr; Retour à l'atelier
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-black font-semibold bg-sky-100 border-l-4 border-sky-500 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white shadow-sm border border-gray-100 border-t-4 border-t-black">
                <div class="p-6 border-b border-gray-100 flex justify-between items-center bg-white">
                    <h3 class="text-lg font-black text-black uppercase tracking-wide">Tous les tickets enregistrés</h3>
                    <a href="{{ route('reparations.create') }}" class="inline-flex items-center px-4 py-2 bg-sky-500 text-white font-bold text-xs uppercase tracking-widest hover:bg-black transition shadow-sm">
                        + Nouveau Ticket
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-black">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">#</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Date</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Client</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Appareil</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Statut</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Total Facturé</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($reparations as $rep)
                            <tr class="hover:bg-sky-50 transition-colors">
                                <td class="px-6 py-4 font-black text-gray-400">#{{ $rep->id }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-600 font-medium">
                                    {{ \Carbon\Carbon::parse($rep->created_at)->format('d/m/Y H:i') }}
                                </td>
                                <td class="px-6 py-4">
                                    <div class="font-black text-black">{{ $rep->client_nom }}</div>
                                    <div class="text-xs text-sky-600 font-bold">{{ $rep->client_telephone }}</div>
                                </td>
                                <td class="px-6 py-4">
                                    <div class="text-sm font-bold text-black">{{ $rep->appareil_marque }}</div>
                                    <div class="text-sm text-gray-500">{{ $rep->appareil_modele }}</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $couleur = match($rep->statut) {
                                            'Payé' => 'bg-green-100 text-green-800 border-green-200',
                                            'Annulé' => 'bg-red-100 text-red-800 border-red-200',
                                            default => 'bg-sky-100 text-sky-700 border-sky-200'
                                        };
                                    @endphp
                                    <span class="inline-flex items-center px-2.5 py-0.5 text-xs font-bold border {{ $couleur }}">
                                            {{ $rep->statut }}
                                        </span>
                                </td>
                                <td class="px-6 py-4 text-right font-black text-black">
                                    {{ $rep->prix_facture_ttc ? number_format($rep->prix_facture_ttc, 2) . ' €' : '-' }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium space-x-3">
                                    <a href="{{ route('reparations.show', $rep->id) }}" class="text-sky-600 hover:text-black font-bold transition">Ouvrir</a>
                                    <a href="{{ route('reparations.edit', $rep->id) }}" class="text-amber-600 hover:text-black font-bold transition">Modifier</a>
                                    <form action="{{ route('reparations.destroy', $rep->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement le ticket #{{ $rep->id }} ?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-black font-bold transition">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center text-gray-500 font-bold">
                                    Aucun ticket dans l'historique pour le moment.
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
