<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
            Modifier la Vente Rapide
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-sky-500">

                <form action="{{ route('caisse.update', $vente->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Désignation</label>
                        <input type="text" name="designation" value="{{ $vente->designation }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-bold text-black">
                    </div>

                    <div class="flex gap-4">
                        <div class="w-24">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Qté</label>
                            <input type="number" name="quantite" value="{{ $vente->quantite }}" min="1" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-bold text-black">
                        </div>
                        <div class="flex-1">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Prix Client (TTC)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="prix_total_ttc" value="{{ $vente->prix_total_ttc }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-lg font-black text-black">
                                <span class="absolute right-3 top-3 text-gray-400 font-bold">€</span>
                            </div>
                        </div>
                    </div>

                    <div class="pt-2 border-t border-gray-100">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Coût d'Achat (Investissement)</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="cout_achat" value="{{ $vente->cout_achat }}" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-bold text-red-600">
                            <span class="absolute right-3 top-2 text-gray-400 font-bold">€</span>
                        </div>
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('caisse.index') }}" class="text-xs font-bold text-gray-500 hover:text-black uppercase transition tracking-wide">Annuler</a>
                        <button type="submit" class="bg-black text-white px-6 py-3 text-sm hover:bg-sky-500 font-black uppercase tracking-wide transition-colors shadow-sm">
                            Enregistrer
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
