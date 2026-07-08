<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
                Modifier le Ticket #{{ $reparation->id }}
            </h2>
            <a href="{{ route('reparations.index') }}" class="text-sm font-bold text-gray-500 hover:text-black transition">
                &larr; Annuler et retour à l'historique
            </a>
        </div>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white p-8 shadow-sm border border-gray-100 border-t-4 border-t-amber-500">

                <form action="{{ route('reparations.update', $reparation->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <!-- Section Client -->
                    <div class="border-b pb-4">
                        <h3 class="font-black text-black uppercase tracking-wide text-sm mb-3">Informations Client</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nom / Prénom du client</label>
                                <input type="text" name="client_nom" value="{{ old('client_nom', $reparation->client_nom) }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Numéro de Téléphone</label>
                                <input type="text" name="client_telephone" value="{{ old('client_telephone', $reparation->client_telephone) }}" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium">
                            </div>
                        </div>
                    </div>

                    <!-- Section Appareil -->
                    <div class="border-b pb-4">
                        <h3 class="font-black text-black uppercase tracking-wide text-sm mb-3">Appareil & Code</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Marque</label>
                                <input type="text" name="appareil_marque" value="{{ old('appareil_marque', $reparation->appareil_marque) }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Modèle</label>
                                <input type="text" name="appareil_modele" value="{{ old('appareil_modele', $reparation->appareil_modele) }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-medium">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Code Déverrouillage</label>
                                <input type="text" name="code_deverrouillage" value="{{ old('code_deverrouillage', $reparation->code_deverrouillage) }}" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-mono font-bold text-red-600">
                            </div>
                        </div>
                    </div>

                    <!-- Section Statut & Prix -->
                    <div>
                        <h3 class="font-black text-black uppercase tracking-wide text-sm mb-3">Facturation & Statut</h3>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Statut du ticket</label>
                                <select name="statut" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-bold">
                                    <option value="En cours" {{ $reparation->statut == 'En cours' ? 'selected' : '' }}>En cours</option>
                                    <option value="En attente de pièce" {{ $reparation->statut == 'En attente de pièce' ? 'selected' : '' }}>En attente de pièce</option>
                                    <option value="Payé" {{ $reparation->statut == 'Payé' ? 'selected' : '' }}>Terminé & Payé</option>
                                    <option value="Annulé" {{ $reparation->statut == 'Annulé' ? 'selected' : '' }}>Annulé / Irréparable</option>
                                </select>
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Prix Total Facturé TTC (€)</label>
                                <input type="number" step="0.01" name="prix_facture_ttc" value="{{ old('prix_facture_ttc', $reparation->prix_facture_ttc) }}" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 text-sm font-black text-black">
                            </div>
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end gap-3">
                        <a href="{{ route('reparations.index') }}" class="px-6 py-3 bg-gray-100 text-gray-700 font-bold text-xs uppercase tracking-widest hover:bg-gray-200 transition">
                            Annuler
                        </a>
                        <button type="submit" class="px-6 py-3 bg-black text-white font-black text-xs uppercase tracking-widest hover:bg-sky-500 transition shadow-sm">
                            Enregistrer les corrections
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
