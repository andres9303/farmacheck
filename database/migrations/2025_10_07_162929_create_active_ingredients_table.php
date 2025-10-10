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
        Schema::create('active_ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255);
            $table->string('description', 1000)->nullable();
            $table->string('atc_code', 10)->nullable()->comment('Código ATC del principio activo');
            $table->string('molecular_formula', 100)->nullable();
            $table->decimal('molecular_weight', 10, 4)->nullable();
            $table->json('therapeutic_actions')->nullable()->comment('Acciones terapéuticas en formato JSON');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('name');
            $table->index('atc_code');
            $table->unique('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('active_ingredients');
    }
};
