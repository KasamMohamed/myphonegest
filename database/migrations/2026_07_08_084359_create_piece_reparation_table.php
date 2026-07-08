<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('piece_reparation', function (Blueprint $table) {
            $table->id();
            // Lien avec la réparation
            $table->foreignId('reparation_id')->constrained()->onDelete('cascade');
            // Lien avec la pièce
            $table->foreignId('piece_id')->constrained()->onDelete('cascade');

            // Les infos spécifiques à cette utilisation
            $table->integer('quantite')->default(1);
            $table->decimal('prix_unitaire_ht_facture', 8, 2)->default(0);
            $table->string('statut_utilisation')->default('Facturé'); // Peut être "Facturé", "Offert", "Cassé au montage"

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('piece_reparation');
    }
};
