<?php

namespace App\Http\Controllers;

use App\Models\Reparation;
use Illuminate\Http\Request;

class ReparationController extends Controller
{
    // 1. Afficher l'historique complet de tous les tickets
    public function index()
    {
        // On récupère toutes les réparations, de la plus récente à la plus ancienne
        $reparations = Reparation::latest('date_depot')->get();
        return view('reparations.index', compact('reparations'));
    }

    // Affiche le formulaire pour enregistrer un nouveau téléphone en atelier
    public function create()
    {
        return view('reparations.create');
    }

    // Sauvegarde le ticket initial
    public function store(Request $request)
    {
        $valide = $request->validate([
            'client_nom' => 'required|string|max:255',
            'client_telephone' => 'required|string|max:20',
            'appareil_marque' => 'required|string|max:255',
            'appareil_modele' => 'required|string|max:255',
            'code_deverrouillage' => 'nullable|string',
            'etat_initial_checklist' => 'nullable|array',
            'prix_main_oeuvre_ht' => 'nullable|numeric'
        ]);

        if(empty($valide['prix_main_oeuvre_ht'])) {
            $valide['prix_main_oeuvre_ht'] = 0;
        }

        Reparation::create($valide);

        return redirect()->route('dashboard')->with('success', 'Ticket créé avec succès !');
    }

    // Afficher la fiche détaillée du ticket
    public function show($id)
    {
        $reparation = Reparation::with(['pieces'])->findOrFail($id);
        // On récupère les pièces disponibles en stock pour le menu déroulant
        $piecesDisponibles = \App\Models\Piece::where('categorie', '!=', 'telephone')->orderBy('nom_article')->get();

        return view('reparations.show', compact('reparation', 'piecesDisponibles'));
    }

    // 2. Afficher le formulaire pour modifier une erreur sur le ticket
    public function edit($id)
    {
        $reparation = Reparation::findOrFail($id);
        return view('reparations.edit', compact('reparation'));
    }

    // 3. Sauvegarder les modifications du ticket suite à une erreur
    public function update(Request $request, $id)
    {
        $reparation = Reparation::findOrFail($id);

        $request->validate([
            'client_nom' => 'required|string|max:255',
            'client_telephone' => 'nullable|string|max:20',
            'appareil_marque' => 'required|string|max:255',
            'appareil_modele' => 'required|string|max:255',
            'code_deverrouillage' => 'nullable|string',
            'imei_ou_serie' => 'nullable|string'
        ]);

        // On met à jour les informations de base
        $reparation->update($request->only([
            'client_nom', 'client_telephone', 'appareil_marque',
            'appareil_modele', 'code_deverrouillage', 'imei_ou_serie'
        ]));

        return redirect()->route('reparations.show', $reparation->id)->with('success', 'Les informations du ticket ont été corrigées !');
    }

    // 4. Supprimer définitivement un ticket (en cas de doublon/erreur)
    public function destroy($id)
    {
        $reparation = Reparation::findOrFail($id);
        $reparation->delete();

        return redirect()->route('reparations.index')->with('success', 'Le ticket a été supprimé définitivement.');
    }

    // Ajouter une pièce spécifique à cette réparation (déduction de stock)
    public function ajouterPiece(Request $request, $id)
    {
        $reparation = Reparation::findOrFail($id);
        $piece = \App\Models\Piece::findOrFail($request->piece_id);

        // On attache la pièce au ticket. Comme le prix final est manuel,
        // on n'a plus besoin d'y lier un prix de vente obligatoire.
        $reparation->pieces()->attach($piece->id, [
            'quantite' => $request->input('quantite', 1),
            'statut_utilisation' => 'Facturé',
            'prix_unitaire_ht_facture' => 0
        ]);

        // On déduit la quantité directement du stock de l'inventaire
        $piece->quantite_en_stock -= $request->input('quantite', 1);
        if ($piece->quantite_en_stock < 0) { $piece->quantite_en_stock = 0; }
        $piece->save();

        return back()->with('success', 'Pièce associée au ticket et déduite du stock !');
    }

    // Mettre à jour le statut du ticket (En cours, Payé, Annulé...) avec le prix total
    public function updateStatut(Request $request, $id)
    {
        $reparation = Reparation::findOrFail($id);

        $request->validate([
            'statut' => 'required|string',
            'prix_facture_ttc' => 'nullable|numeric',
            'cout_pieces_investi' => 'nullable|numeric' // Validation du coût d'achat
        ]);

        $reparation->statut = $request->statut;

        // Sauvegarde du prix total payé par le client
        if ($request->filled('prix_facture_ttc')) {
            $reparation->prix_facture_ttc = $request->prix_facture_ttc;
        }

        // Sauvegarde du coût des pièces investi par le magasin
        if ($request->filled('cout_pieces_investi')) {
            $reparation->cout_pieces_investi = $request->cout_pieces_investi;
        }

        $reparation->save();

        return redirect()->back()->with('success', 'Ticket et données comptables mis à jour !');
    }
}
