<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
                Ticket #{{ $reparation->id }} - <span class="text-sky-500">{{ $reparation->appareil_marque }} {{ $reparation->appareil_modele }}</span>
            </h2>
            <a href="{{ route('dashboard') }}" class="text-sm font-bold text-gray-500 hover:text-black transition">
                &larr; Retour à l'atelier
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-black font-semibold bg-sky-100 border-l-4 border-sky-500">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                <div class="space-y-6 md:col-span-1">

                    <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-black">
                        <h3 class="text-lg font-black mb-4 pb-2 text-black uppercase">Statut & Facturation</h3>
                        <form action="{{ route('reparations.updateStatut', $reparation->id) }}" method="POST" class="flex flex-col gap-4">
                            @csrf

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Statut</label>
                                <select name="statut" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-medium">
                                    <option value="En cours" {{ $reparation->statut == 'En cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="En attente de pièce" {{ $reparation->statut == 'En attente de pièce' ? 'selected' : '' }}>En attente de pièce</option>
                                    <option value="Payé" {{ $reparation->statut == 'Payé' ? 'selected' : '' }}>Terminé & Payé</option>
                                    <option value="Annulé" {{ $reparation->statut == 'Annulé' ? 'selected' : '' }}>Annulé / Irréparable</option>
                                </select>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Prix total encaissé</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="prix_facture_ttc" value="{{ $reparation->prix_facture_ttc }}" placeholder="Montant facturé" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-black text-black">
                                    <span class="absolute right-3 top-2 text-gray-400 font-bold">€</span>
                                </div>
                            </div>

                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Coût des pièces (Achat)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="cout_pieces_investi" value="{{ $reparation->cout_pieces_investi }}" placeholder="Votre investissement" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-bold text-red-600">
                                    <span class="absolute right-3 top-2 text-gray-400 font-bold">€</span>
                                </div>
                            </div>

                            <button type="submit" class="mt-2 bg-black text-white px-4 py-2.5 text-sm hover:bg-sky-500 font-black uppercase tracking-wider transition w-full shadow-sm">
                                Enregistrer
                            </button>
                        </form>
                    </div>

                    <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-sky-500">
                        <h3 class="text-lg font-black mb-4 pb-2 text-black uppercase">Informations</h3>
                        <div class="space-y-3 text-sm">
                            <p><strong class="text-black">Client :</strong> {{ $reparation->client_nom }}</p>
                            <p><strong class="text-black">Téléphone :</strong> <span class="text-sky-600 font-bold">{{ $reparation->client_telephone ?? 'Non renseigné' }}</span></p>

                            <div class="pt-3 border-t border-gray-100">
                                <p><strong class="text-black">Appareil :</strong> {{ $reparation->appareil_marque }} {{ $reparation->appareil_modele }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p><strong class="text-black">Code :</strong> <span class="font-mono bg-black text-white px-2 py-1 rounded-none font-bold">{{ $reparation->code_deverrouillage ?? 'Aucun' }}</span></p>

                                    @if($reparation->appareil_depose)
                                        <span class="px-2 py-1 bg-sky-100 text-sky-700 text-xs font-black uppercase tracking-wider border border-sky-200 shadow-sm">
                                            À l'atelier
                                        </span>
                                    @else
                                        <span class="px-2 py-1 bg-gray-100 text-gray-500 text-xs font-black uppercase tracking-wider border border-gray-200 shadow-sm">
                                            Chez le client
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="pt-3 border-t border-gray-100">
                                <strong class="text-black">État initial (Checklist) :</strong>
                                @if($reparation->etat_initial_checklist && is_array($reparation->etat_initial_checklist))
                                    <ul class="list-disc list-inside text-gray-700 mt-2 space-y-1 font-medium">
                                        @foreach($reparation->etat_initial_checklist as $etat)
                                            <li>{{ $etat }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-gray-400 italic mt-1">Rien de spécifique signalé.</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>

                <div class="space-y-6 md:col-span-2">

                    <div class="bg-white p-6 shadow-sm border border-gray-100 border-l-4 border-l-black">
                        <h3 class="text-lg font-black mb-4 text-black uppercase">Pièces utilisées (Déduire du stock)</h3>
                        <form action="{{ route('reparations.ajouterPiece', $reparation->id) }}" method="POST" class="flex flex-col sm:flex-row gap-4">
                            @csrf
                            <div class="flex-1">
                                <select name="piece_id" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-medium" required>
                                    <option value="">-- Sélectionner une pièce en stock --</option>
                                    @foreach($piecesDisponibles as $piece)
                                        <option value="{{ $piece->id }}">
                                            {{ $piece->nom_article }} (En stock: {{ $piece->quantite_en_stock }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="w-24">
                                <input type="number" name="quantite" value="1" min="1" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm" placeholder="Qté">
                            </div>
                            <div>
                                <button type="submit" class="w-full bg-sky-500 text-white px-6 py-2 text-sm hover:bg-black font-black uppercase tracking-wide transition-colors">
                                    + Ajouter
                                </button>
                            </div>
                        </form>
                    </div>

                    <div class="bg-white shadow-sm border border-gray-100">
                        <div class="p-6 border-b border-gray-100">
                            <h3 class="text-lg font-black text-black uppercase">Consommables sur ce ticket</h3>
                            <p class="text-xs text-gray-500 mt-1">Ces pièces ont été déduites de votre inventaire.</p>
                        </div>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-100">
                                <thead class="bg-black">
                                <tr>
                                    <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Désignation de la pièce</th>
                                    <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase">Qté utilisée</th>
                                </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100 bg-white">
                                @forelse($reparation->pieces as $piece)
                                    <tr class="hover:bg-sky-50 transition">
                                        <td class="px-6 py-4 text-sm font-bold text-gray-800">{{ $piece->nom_article }}</td>
                                        <td class="px-6 py-4 text-sm text-center font-medium">{{ $piece->pivot->quantite }}</td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="2" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">
                                            Aucune pièce du stock n'a été utilisée pour le moment.
                                        </td>
                                    </tr>
                                @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
