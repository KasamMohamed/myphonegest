<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            // Si on supprime la pièce du catalogue plus tard, on garde quand même l'historique de la vente
            $table->foreignId('piece_id')->nullable()->constrained('pieces')->onDelete('set null');
            $table->string('nom_article_vendu');
            $table->integer('quantite');
            $table->decimal('prix_total_ttc', 8, 2);
            $table->timestamp('date_vente')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ventes');
    }
};
