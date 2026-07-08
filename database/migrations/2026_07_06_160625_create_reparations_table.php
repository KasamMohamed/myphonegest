<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reparations', function (Blueprint $table) {
            $table->id();

            // Infos rapides du client
            $table->string('client_nom');
            $table->string('client_telephone');

            // Infos rapides de l'appareil
            $table->string('appareil_marque');
            $table->string('appareil_modele');

            // Le reste du ticket
            $table->string('code_deverrouillage')->nullable();
            $table->json('etat_initial_checklist')->nullable();
            $table->decimal('prix_main_oeuvre_ht', 8, 2)->default(0);
            $table->string('statut')->default('À réparer');
            $table->date('date_depot')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('piece_reparation');
        Schema::dropIfExists('reparations');
    }
};
