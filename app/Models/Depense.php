<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Depense extends Model
{
    use HasFactory;

    // On autorise l'insertion rapide pour ces trois colonnes
    protected $fillable = [
        'titre',
        'montant_ttc',
        'date_depense'
    ];
}
