<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Saisir une nouvelle dépense
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">

                <form method="POST" action="{{ route('depenses.store') }}" class="space-y-6">
                    @csrf

                    <div>
                        <x-input-label for="titre" value="Titre / Motif (ex: Loyer, Électricité, Outils)" />
                        <x-text-input id="titre" name="titre" type="text" class="mt-1 block w-full" required autofocus />
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="montant_ttc" value="Montant TTC (€)" />
                            <x-text-input id="montant_ttc" name="montant_ttc" type="number" step="0.01" class="mt-1 block w-full" required />
                        </div>

                        <div>
                            <x-input-label for="date_depense" value="Date de la facture" />
                            <x-text-input id="date_depense" name="date_depense" type="date" class="mt-1 block w-full" value="{{ date('Y-m-d') }}" required />
                        </div>
                    </div>

                    <div class="flex items-center justify-end gap-4 mt-6">
                        <a href="{{ route('depenses.index') }}" class="text-sm text-gray-600 hover:text-gray-900 underline">Annuler</a>
                        <x-primary-button>Enregistrer la charge</x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>
