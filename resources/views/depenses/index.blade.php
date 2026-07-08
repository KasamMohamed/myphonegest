<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
            Charges & Dépenses
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            @if(session('success'))
                <div class="p-4 mb-4 text-sm text-black font-semibold rounded-none bg-sky-100 border-l-4 border-sky-500 shadow-sm">
                    {{ session('success') }}
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-black md:col-span-1 h-fit">
                    <h3 class="text-lg font-black mb-4 pb-2 text-black uppercase border-b border-gray-100">
                        Nouvelle dépense
                    </h3>
                    <form action="{{ route('depenses.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Motif / Titre</label>
                            <input type="text" name="titre" required placeholder="Ex: Loyer, Électricité..." class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Montant TTC</label>
                            <div class="relative">
                                <input type="number" step="0.01" name="montant_ttc" required placeholder="0.00" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-lg font-black text-black">
                                <span class="absolute right-3 top-3 text-gray-400 font-bold">€</span>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Date</label>
                            <input type="date" name="date_depense" required value="{{ date('Y-m-d') }}" class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                        </div>

                        <button type="submit" class="w-full bg-black text-white px-6 py-3 text-sm hover:bg-sky-500 font-black uppercase tracking-wide transition-colors shadow-sm">
                            Enregistrer
                        </button>
                    </form>
                </div>

                <div class="bg-white shadow-sm border border-gray-100 border-t-4 border-t-sky-500 md:col-span-2">
                    <div class="p-6 border-b border-gray-100">
                        <h3 class="text-lg font-black text-sky-600 uppercase">Historique des dépenses</h3>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-100">
                            <thead class="bg-black">
                            <tr>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Date</th>
                                <th class="px-6 py-4 text-left text-xs font-bold text-white uppercase">Motif</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Montant</th>
                                <th class="px-6 py-4 text-right text-xs font-bold text-white uppercase">Actions</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100 bg-white">
                            @forelse ($depenses as $dep)
                                <tr class="hover:bg-sky-50 transition">
                                    <td class="px-6 py-4 text-sm text-gray-600 font-medium whitespace-nowrap">{{ \Carbon\Carbon::parse($dep->date_depense)->format('d/m/Y') }}</td>
                                    <td class="px-6 py-4 text-sm font-bold text-black">{{ $dep->titre }}</td>
                                    <td class="px-6 py-4 text-sm font-black text-red-600 text-right whitespace-nowrap">- {{ number_format($dep->montant_ttc, 2) }} €</td>
                                    <td class="px-6 py-4 text-sm text-right whitespace-nowrap flex justify-end gap-3">
                                        <a href="{{ route('depenses.edit', $dep->id) }}" class="text-sky-500 hover:text-black font-black uppercase text-xs transition">Modifier</a>
                                        <form action="{{ route('depenses.destroy', $dep->id) }}" method="POST" onsubmit="return confirm('Supprimer définitivement cette dépense ?');" class="inline">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-500 hover:text-red-700 font-black uppercase text-xs transition">Supprimer</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500 font-medium">Aucune dépense enregistrée.</td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
