<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
            Nouveau Ticket de Réparation
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-5xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-black">
                <form action="{{ route('reparations.store') }}" method="POST" class="space-y-8">
                    @csrf

                    <div>
                        <h3 class="text-lg font-black mb-4 pb-2 text-black uppercase border-b border-gray-100">1. Informations Client</h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nom du client</label>
                                <input type="text" name="client_nom" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Téléphone</label>
                                <input type="text" name="client_telephone" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-bold text-sky-600">
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-black mb-4 pb-2 text-black uppercase border-b border-gray-100">2. L'Appareil</h3>
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Marque</label>
                                <input type="text" name="appareil_marque" required placeholder="Ex: Apple, Samsung..." class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Modèle</label>
                                <input type="text" name="appareil_modele" required placeholder="Ex: iPhone 13, Galaxy S22..." class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Code / Schéma</label>
                                <input type="text" name="code_deverrouillage" placeholder="Laisser vide si aucun" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-mono">
                            </div>

                            <div class="col-span-1 md:col-span-3 pt-4 border-t border-gray-100 mt-2">
                                <label class="flex items-center space-x-3 p-4 border border-sky-200 bg-sky-50 cursor-pointer hover:bg-sky-100 transition-colors">
                                    <input type="checkbox" name="appareil_depose" value="1" checked class="rounded-none border-gray-300 text-sky-500 focus:ring-sky-500 h-5 w-5">
                                    <div>
                                        <span class="block text-sm font-black text-sky-700 uppercase tracking-wide">L'appareil est déposé à l'atelier</span>
                                        <span class="block text-xs font-bold text-gray-500 mt-1">Laissez coché si le téléphone reste dans vos tiroirs. Décochez si le client repart avec (ex: en attente de commande de pièce).</span>
                                    </div>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div>
                        <h3 class="text-lg font-black mb-4 pb-2 text-black uppercase border-b border-gray-100">3. Diagnostic & Pannes signalées</h3>
                        <p class="text-xs text-gray-500 mb-4">Cochez les éléments à réparer ou les défauts constatés au dépôt.</p>

                        @php
                            $pannes = [
                                'Écran cassé / Tactile HS',
                                'Batterie à remplacer',
                                'Connecteur de charge',
                                'Lentille caméra arrière',
                                'Caméra Avant / Arrière HS',
                                'Vibreur',
                                'Haut-parleur / Micro HS',
                                'Bouton Power (Allumage)',
                                'Boutons Volume',
                                'Problème réseau / Wi-Fi',
                                'Désoxydation (Eau)',
                                'Problème logiciel (MAJ)'
                            ];
                        @endphp

                        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3">
                            @foreach($pannes as $panne)
                                <label class="flex items-center space-x-3 p-3 border border-gray-100 hover:bg-sky-50 cursor-pointer transition-colors">
                                    <input type="checkbox" name="etat_initial_checklist[]" value="{{ $panne }}" class="rounded-none border-gray-300 text-sky-500 focus:ring-sky-500 h-5 w-5">
                                    <span class="text-sm font-bold text-gray-700">{{ $panne }}</span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-6 border-t border-gray-100">
                        <a href="{{ route('dashboard') }}" class="text-xs font-bold text-gray-500 hover:text-black uppercase transition tracking-wide">Annuler</a>
                        <button type="submit" class="bg-black text-white px-8 py-4 text-sm hover:bg-sky-500 font-black uppercase tracking-wide transition-colors shadow-sm">
                            + Créer le Ticket
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</x-app-layout>
