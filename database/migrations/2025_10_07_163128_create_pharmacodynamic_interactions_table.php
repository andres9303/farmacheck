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
        Schema::create('pharmacodynamic_interactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('medication_1_id')->constrained('medications')->onDelete('cascade');
            $table->foreignId('medication_2_id')->constrained('medications')->onDelete('cascade');
            $table->foreignId('compatibility_type_id')->constrained()->onDelete('restrict');
            $table->string('interaction_type', 100)->comment('Tipo de interacción: sinérgica, antagonista, etc.');
            $table->text('description')->comment('Descripción detallada de la interacción');
            $table->text('mechanism')->nullable()->comment('Mecanismo de la interacción');
            $table->text('clinical_effects')->nullable()->comment('Efectos clínicos de la interacción');
            $table->text('recommendations')->nullable()->comment('Recomendaciones para manejar la interacción');
            $table->json('evidence_level')->nullable()->comment('Nivel de evidencia científica en JSON');
            $table->string('source', 255)->nullable()->comment('Fuente de la información');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->unique(['medication_1_id', 'medication_2_id'], 'unique_pharmacodynamic_pair');
            $table->index('medication_1_id');
            $table->index('medication_2_id');
            $table->index('compatibility_type_id');
            $table->index('interaction_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacodynamic_interactions');
    }
};
