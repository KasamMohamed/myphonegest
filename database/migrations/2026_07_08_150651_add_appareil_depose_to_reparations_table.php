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
            // "boolean" veut dire Vrai/Faux. Par défaut, on considère que le client le dépose.
            $table->boolean('appareil_depose')->default(true)->after('code_deverrouillage');
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
