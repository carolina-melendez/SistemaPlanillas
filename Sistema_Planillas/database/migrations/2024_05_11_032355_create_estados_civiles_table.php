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
        Schema::create('estados_civiles', function (Blueprint $table) {
            $table->bigIncrements('id_estado_civil');
            $table->string('descripcion', 100);
            $table->timestamps(); // Crear automáticamente las columnas `created_at`
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('estados_civiles');
    }
};
