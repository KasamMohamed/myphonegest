<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Piece extends Model
{
    // On désactive la sécurité bloquante pour autoriser l'ajout d'articles
    protected $guarded = [];
}
