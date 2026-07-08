<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
            Stock & Accessoires
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-black font-semibold bg-sky-100 border-l-4 border-sky-500 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-sky-500">
                <h3 class="text-lg font-black mb-4 text-black uppercase tracking-wide">Ajouter un article</h3>

                <form action="{{ route('pieces.store') }}" method="POST" class="flex flex-col md:flex-row gap-4 items-end">
                    @csrf
                    <div class="flex-1">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Nom de l'article</label>
                        <input type="text" name="nom_article" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm" placeholder="Ex: Écran iPhone 13">
                    </div>

                    <div class="w-32">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Catégorie</label>
                        <select name="categorie" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                            <option value="Pièce">Pièce</option>
                            <option value="Accessoire">Accessoire</option>
                            <option value="Téléphone">Téléphone</option>
                        </select>
                    </div>

                    <div class="w-24">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Achat HT</label>
                        <input type="number" step="0.01" name="prix_achat_ht" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm" placeholder="€">
                    </div>

                    <div class="w-24">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Qté</label>
                        <input type="number" name="quantite_en_stock" value="1" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                    </div>

                    <div class="w-24">
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Alerte</label>
                        <input type="number" name="seuil_alerte" value="2" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm" title="Seuil d'alerte">
                    </div>

                    <div>
                        <button type="submit" class="bg-black text-white px-6 py-2 text-sm hover:bg-sky-500 font-black uppercase tracking-wide transition-colors h-10 shadow-sm">
                            Ajouter
                        </button>
                    </div>
                </form>
            </div>

            <div class="bg-white shadow-sm border border-gray-100">
                <div class="p-6 border-b border-gray-100 bg-white">
                    <h3 class="text-lg font-black text-black uppercase tracking-wide">Inventaire actuel</h3>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-100">
                        <thead class="bg-black">
                        <tr>
                            <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Article</th>
                            <th class="px-6 py-4 text-center text-xs font-bold text-white uppercase">Quantité</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Prix Achat</th>
                            <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white">
                        @forelse ($pieces ?? [] as $piece)
                            <tr class="hover:bg-sky-50 transition-colors {{ $piece->quantite_en_stock <= $piece->seuil_alerte ? 'bg-red-50' : '' }}">
                                <td class="px-6 py-4">
                                    <div class="font-bold text-gray-900">{{ $piece->nom_article }}</div>
                                    <div class="text-xs font-bold text-sky-600 uppercase tracking-wider">{{ $piece->categorie }}</div>
                                </td>

                                <td class="px-6 py-4 text-center">
                                    <div class="flex items-center justify-center gap-3">
                                        <form action="{{ route('pieces.updateQuantite', $piece->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="sub">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-gray-100 text-gray-700 hover:bg-black hover:text-white font-black transition-colors rounded-none shadow-sm">-</button>
                                        </form>

                                        <span class="text-lg font-black {{ $piece->quantite_en_stock <= $piece->seuil_alerte ? 'text-red-600' : 'text-black' }}">
                                                {{ $piece->quantite_en_stock }}
                                            </span>

                                        <form action="{{ route('pieces.updateQuantite', $piece->id) }}" method="POST" class="inline">
                                            @csrf @method('PATCH')
                                            <input type="hidden" name="action" value="add">
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-sky-100 text-sky-700 hover:bg-sky-500 hover:text-white font-black transition-colors rounded-none shadow-sm">+</button>
                                        </form>
                                    </div>
                                </td>

                                <td class="px-6 py-4 text-right text-sm text-gray-500 font-medium">{{ number_format($piece->prix_achat_ht, 2) }} €</td>

                                <td class="px-6 py-4 text-right">
                                    <form action="{{ route('pieces.destroy', $piece->id) }}" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer définitivement cet article du catalogue ?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs font-bold text-red-500 hover:text-red-700 uppercase tracking-wider transition-colors">
                                            Supprimer
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-12 text-center">
                                    <h3 class="mt-2 text-sm font-bold text-black">Le stock est vide</h3>
                                    <p class="mt-1 text-sm text-gray-500">Ajoutez vos premières pièces détachées en haut de la page.</p>
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
