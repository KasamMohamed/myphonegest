<?php

namespace App\Http\Controllers;

use App\Models\Reparation;
use App\Models\Vente;
use App\Models\Depense;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. On affiche uniquement les réparations actives sur le tableau de bord
        $reparations = Reparation::whereNotIn('statut', ['Payé', 'Annulé'])
            ->latest('date_depot')
            ->get();

        // 2. Calculs Financiers de l'Atelier
        $reparationsTerminees = Reparation::with('pieces')->where('statut', 'Payé')->get();

        $caAtelier = 0;
        $coutPieces = 0;

        foreach ($reparationsTerminees as $rep) {
            // Le CA est le prix manuel que vous avez facturé
            $caAtelier += $rep->prix_facture_ttc ?? 0;

            // NOUVEAU : On prend en priorité le coût que vous avez tapé à la main !
            if ($rep->cout_pieces_investi > 0) {
                $coutPieces += $rep->cout_pieces_investi;
            } else {
                // Si la case est vide, on calcule avec les pièces déduites du stock
                foreach ($rep->pieces as $piece) {
                    $coutPieces += ($piece->prix_achat_ht * $piece->pivot->quantite);
                }
            }
        }

        // 3. Ventes de la Caisse rapide
        $caCaisse = Vente::sum('prix_total_ttc');
        $coutVentesCaisse = Vente::sum('cout_achat'); // On récupère tous les coûts d'achats saisis

        // 4. Calculs finaux
        $totalCA = $caAtelier + $caCaisse;
        $totalDepenses = Depense::sum('montant_ttc');

        // On additionne le coût des pièces d'atelier ET le coût des accessoires vendus en caisse
        $totalCoutInvesti = $coutPieces + $coutVentesCaisse;

        // 5. Bénéfice Net exact
        $beneficeNet = $totalCA - $totalCoutInvesti - $totalDepenses;

        return view('dashboard', compact(
            'reparations',
            'totalCA',
            'coutPieces',
            'totalDepenses',
            'beneficeNet'
        ));
    }
}
