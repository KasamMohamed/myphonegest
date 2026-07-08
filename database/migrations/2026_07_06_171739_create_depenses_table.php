<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // On détruit l'ancienne table qui bloque, pour faire place à la nouvelle
        Schema::dropIfExists('depenses');

        Schema::create('depenses', function (Blueprint $table) {
            $table->id();
            $table->string('titre');
            $table->decimal('montant_ttc', 8, 2);
            $table->date('date_depense');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('depenses');
    }
};
