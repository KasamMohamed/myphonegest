<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
            Caisse & Vente Rapide
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-black font-semibold rounded-none bg-sky-100 border-l-4 border-sky-500 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-black">
                    <h3 class="text-lg font-black mb-4 pb-2 text-black uppercase border-b border-gray-100">
                        Prestation / Diagnostic
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">Encaissez une prestation immatérielle de l'atelier.</p>

                    <form action="{{ route('caisse.encaisser') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Désignation</label>
                            <input type="text" name="designation" required placeholder="Ex: Diagnostic iPhone 12, Pose Verre Trempé..." class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Prix Encaissé (TTC)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="prix_total_ttc" required placeholder="0.00" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-lg font-black text-black">
                                <span class="absolute right-3 top-3 text-gray-400 font-bold">€</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-black text-white px-6 py-3 text-sm hover:bg-sky-500 font-black uppercase tracking-wide transition-colors shadow-sm mt-2">
                            Encaisser la prestation
                        </button>
                    </form>
                </div>

                <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-sky-500">
                    <h3 class="text-lg font-black mb-4 pb-2 text-sky-600 uppercase border-b border-gray-100">
                        Accessoire / Produit
                    </h3>
                    <p class="text-xs text-gray-500 mb-4">Vendez un article directement au comptoir.</p>

                    <form action="{{ route('caisse.encaisser') }}" method="POST" class="space-y-4">
                        @csrf

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Désignation de l'article</label>
                            <input type="text" name="designation" required placeholder="Ex: Coque Silicone S23, Câble USB-C..." class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                        </div>

                        <div class="flex gap-4">
                            <div class="w-24">
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Qté</label>
                                <input type="number" name="quantite" value="1" min="1" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                            </div>
                            <div class="flex-1">
                                <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Prix Client (TTC)</label>
                                <div class="relative">
                                    <input type="number" step="0.01" name="prix_total_ttc" required placeholder="0.00" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-lg font-black text-black">
                                    <span class="absolute right-3 top-3 text-gray-400 font-bold">€</span>
                                </div>
                            </div>
                        </div>

                        <div class="pt-2 border-t border-gray-100">
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Votre Prix d'Achat (Investissement)</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="cout_achat" placeholder="Ex: 5.50" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-bold text-red-600">
                                <span class="absolute right-3 top-2 text-gray-400 font-bold">€</span>
                            </div>
                        </div>

                        <button type="submit" class="w-full bg-sky-500 text-white px-6 py-3 text-sm hover:bg-black font-black uppercase tracking-wide transition-colors shadow-sm">
                            Encaisser l'article
                        </button>
                    </form>
                </div>

            </div>

            <div class="mt-8 bg-white shadow-sm border border-gray-100">
                <div class="p-4 border-b border-gray-100 bg-gray-50">
                    <h3 class="text-sm font-black text-gray-700 uppercase tracking-wide">Ventes Rapides du jour</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-black">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wide">Heure</th>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase tracking-wide">Article / Prestation</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wide">Montant</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase tracking-wide">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($ventesDuJour as $vente)
                            <tr class="hover:bg-sky-50 transition">
                                <td class="px-6 py-3 text-sm text-gray-500 w-32 font-medium">{{ $vente->created_at->format('H:i') }}</td>
                                <td class="px-6 py-3 text-sm font-bold text-black">{{ $vente->quantite }}x {{ $vente->designation }}</td>
                                <td class="px-6 py-3 text-sm font-black text-sky-600 text-right whitespace-nowrap">+ {{ number_format($vente->prix_total_ttc, 2) }} €</td>
                                <td class="px-6 py-3 text-sm text-right whitespace-nowrap flex justify-end gap-3 items-center">
                                    <a href="{{ route('caisse.edit', $vente->id) }}" class="text-sky-500 hover:text-black font-black uppercase text-xs transition tracking-wide">Modifier</a>
                                    <form action="{{ route('caisse.destroy', $vente->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cet encaissement ?');" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:text-red-700 font-black uppercase text-xs transition tracking-wide">Supprimer</button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">Aucune vente rapide aujourd'hui.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
