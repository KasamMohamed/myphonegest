<?php

namespace App\Http\Controllers;

use App\Models\Depense;
use Illuminate\Http\Request;

class DepenseController extends Controller
{
    public function index()
    {
        // On récupère toutes les dépenses de la plus récente à la plus ancienne
        $depenses = Depense::latest('date_depense')->get();
        return view('depenses.index', compact('depenses'));
    }

    public function store(Request $request)
    {
        $valide = $request->validate([
            'titre' => 'required|string|max:255',
            'montant_ttc' => 'required|numeric',
            'date_depense' => 'required|date',
        ]);

        Depense::create($valide);

        return redirect()->route('depenses.index')->with('success', 'Dépense enregistrée en comptabilité !');
    }

    // Afficher le formulaire de modification
    public function edit($id)
    {
        $depense = Depense::findOrFail($id);
        return view('depenses.edit', compact('depense'));
    }

    // Enregistrer les modifications
    public function update(Request $request, $id)
    {
        $depense = Depense::findOrFail($id);

        $valide = $request->validate([
            'titre' => 'required|string|max:255',
            'montant_ttc' => 'required|numeric',
            'date_depense' => 'required|date',
        ]);

        $depense->update($valide);

        return redirect()->route('depenses.index')->with('success', 'Dépense corrigée avec succès !');
    }

    // Supprimer une dépense
    public function destroy($id)
    {
        $depense = Depense::findOrFail($id);
        $depense->delete();

        return redirect()->route('depenses.index')->with('success', 'La dépense a été supprimée de la comptabilité.');
    }
}
