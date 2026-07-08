<x-app-layout>
    <x-slot name="header">
        <h2 class="font-black text-xl text-black leading-tight uppercase tracking-wide">
            Modifier la dépense
        </h2>
    </x-slot>

    <div class="py-12 bg-gray-50 min-h-screen">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8 space-y-6">

            <div class="bg-white p-6 shadow-sm border border-gray-100 border-t-4 border-t-sky-500">

                <form action="{{ route('depenses.update', $depense->id) }}" method="POST" class="space-y-6">
                    @csrf
                    @method('PUT')

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Motif / Titre</label>
                        <input type="text" name="titre" value="{{ $depense->titre }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm font-bold">
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Montant TTC</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="montant_ttc" value="{{ $depense->montant_ttc }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-lg font-black text-black">
                            <span class="absolute right-3 top-3 text-gray-400 font-bold">€</span>
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-gray-700 uppercase mb-1">Date</label>
                        <input type="date" name="date_depense" value="{{ \Carbon\Carbon::parse($depense->date_depense)->format('Y-m-d') }}" required class="block w-full border-gray-300 focus:border-sky-500 focus:ring-sky-500 rounded-none shadow-sm text-sm">
                    </div>

                    <div class="flex items-center justify-between pt-4 border-t border-gray-100">
                        <a href="{{ route('depenses.index') }}" class="text-xs font-bold text-gray-500 hover:text-black uppercase transition">Annuler</a>
                        <button type="submit" class="bg-black text-white px-6 py-3 text-sm hover:bg-sky-500 font-black uppercase tracking-wide transition-colors shadow-sm">
                            Enregistrer les modifications
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</x-app-layout>
