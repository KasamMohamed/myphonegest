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
        Schema::table('reparations', function (Blueprint $table) {
            // On ajoute le coût d'achat des pièces juste après le prix total facturé
            $table->decimal('cout_pieces_investi', 8, 2)->nullable()->after('prix_facture_ttc');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reparations', function (Blueprint $table) {
            //
        });
    }
};
