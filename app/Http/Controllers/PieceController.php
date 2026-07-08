<?php

namespace App\Http\Controllers;

use App\Models\Piece;
use Illuminate\Http\Request;

class PieceController extends Controller
{
    public function index()
    {
        // On trie par catégorie (pièces, accessoires, téléphones)
        $pieces = Piece::orderBy('categorie')->orderBy('nom_article')->get();
        return view('pieces.index', compact('pieces'));
    }

    public function create()
    {
        return view('pieces.create');
    }

    public function store(Request $request)
    {
        $valide = $request->validate([
            'nom_article' => 'required|string|max:255',
            'categorie' => 'required|string',
            'prix_achat_ht' => 'required|numeric',
            'quantite_en_stock' => 'required|integer',
            'seuil_alerte' => 'required|integer',
        ]);

        \App\Models\Piece::create($valide);

        return redirect()->route('pieces.index')->with('success', 'Article ajouté au stock !');
    }

    // Fonction pour ajuster la quantité (+ ou -)
    public function updateQuantite(Request $request, $id)
    {
        $piece = \App\Models\Piece::findOrFail($id);
        $action = $request->input('action'); // 'add' ou 'sub'
        $qte = (int) $request->input('quantite', 1);

        if ($action === 'add') {
            $piece->quantite_en_stock += $qte;
        } elseif ($action === 'sub') {
            $piece->quantite_en_stock -= $qte;
            // On empêche le stock de descendre en dessous de 0
            if ($piece->quantite_en_stock < 0) {
                $piece->quantite_en_stock = 0;
            }
        }

        $piece->save();

        return redirect()->route('pieces.index')->with('success', 'Quantité mise à jour !');
    }

    // Fonction pour supprimer définitivement un article du catalogue
    public function destroy($id)
    {
        $piece = \App\Models\Piece::findOrFail($id);
        $piece->delete();

        return redirect()->route('pieces.index')->with('success', 'Article supprimé définitivement du stock.');
    }
}
