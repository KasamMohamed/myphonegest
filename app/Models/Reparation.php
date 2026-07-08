<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reparation extends Model
{
    // On autorise l'enregistrement de toutes les données
    protected $guarded = [];

    // On dit à Laravel de transformer la checklist (tableau) en texte pour la base de données
    protected $casts = [
        'etat_initial_checklist' => 'array',
    ];

    // La liaison avec les pièces
    public function pieces()
    {
        return $this->belongsToMany(Piece::class, 'piece_reparation')
            ->withPivot('quantite', 'prix_unitaire_ht_facture', 'statut_utilisation')
            ->withTimestamps();
    }
}
