<?php

namespace App\Http\Controllers;

use App\Models\Vente;
use Illuminate\Http\Request;

class CaisseController extends Controller
{
    public function index()
    {
        $ventesDuJour = Vente::whereDate('created_at', today())->latest()->get();
        return view('caisse.index', compact('ventesDuJour'));
    }

    public function encaisser(Request $request)
    {
        $request->validate([
            'designation' => 'required|string|max:255',
            'prix_total_ttc' => 'required|numeric|min:0',
            'cout_achat' => 'nullable|numeric|min:0',
            'quantite' => 'nullable|integer|min:1'
        ]);

        Vente::create([
            'designation' => $request->designation,
            'prix_total_ttc' => $request->prix_total_ttc,
            'cout_achat' => $request->cout_achat ?? 0,
            'quantite' => $request->input('quantite', 1),
        ]);

        return redirect()->back()->with('success', 'Vente encaissée avec succès !');
    }

    // NOUVEAU : Afficher le formulaire de modification
    public function edit($id)
    {
        $vente = Vente::findOrFail($id);
        return view('caisse.edit', compact('vente'));
    }

    // NOUVEAU : Sauvegarder la modification
    public function update(Request $request, $id)
    {
        $vente = Vente::findOrFail($id);

        $request->validate([
            'designation' => 'required|string|max:255',
            'prix_total_ttc' => 'required|numeric|min:0',
            'cout_achat' => 'nullable|numeric|min:0',
            'quantite' => 'required|integer|min:1'
        ]);

        $vente->update([
            'designation' => $request->designation,
            'prix_total_ttc' => $request->prix_total_ttc,
            'cout_achat' => $request->cout_achat ?? 0,
            'quantite' => $request->quantite,
        ]);

        return redirect()->route('caisse.index')->with('success', 'La vente a été corrigée !');
    }

    // NOUVEAU : Supprimer une vente
    public function destroy($id)
    {
        $vente = Vente::findOrFail($id);
        $vente->delete();

        return redirect()->route('caisse.index')->with('success', 'Vente supprimée de la caisse.');
    }
}
