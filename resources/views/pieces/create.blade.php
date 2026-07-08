<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Ajouter une nouvelle pièce
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('pieces.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="nom_article" value="Nom de l'article (ex: Écran iPhone 13)" />
                        <x-text-input id="nom_article" name="nom_article" type="text" class="mt-1 block w-full" required autofocus />
                    </div>

                    <div>
                        <x-input-label for="categorie" value="Catégorie" />
                        <select id="categorie" name="categorie" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                            <option value="piece_detachee">Pièce détachée (Écran, Batterie...)</option>
                            <option value="accessoire">Accessoire (Coque, Chargeur...)</option>
                            <option value="telephone">Téléphone (Reconditionné/Occasion)</option>
                            <option value="consommable">Consommable (Hydrogel, Colle...)</option>
                        </select>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="prix_achat_ht" value="Prix d'achat HT (€)" />
                            <x-text-input id="prix_achat_ht" name="prix_achat_ht" type="number" step="0.01" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="prix_vente_ttc" value="Prix de vente TTC (€)" />
                            <x-text-input id="prix_vente_ttc" name="prix_vente_ttc" type="number" step="0.01" class="mt-1 block w-full" required />
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="quantite_en_stock" value="Quantité en stock" />
                            <x-text-input id="quantite_en_stock" name="quantite_en_stock" type="number" class="mt-1 block w-full" value="0" required />
                        </div>

                        <div>
                            <x-input-label for="seuil_alerte" value="Seuil d'alerte (Rupture)" />
                            <x-text-input id="seuil_alerte" name="seuil_alerte" type="number" class="mt-1 block w-full" value="2" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-6">
                        <a href="{{ route('pieces.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Annuler</a>
                        <x-primary-button>Ajouter au stock</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
