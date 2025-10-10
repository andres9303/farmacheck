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
        Schema::create('concentration_units', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('symbol', 10)->unique()->comment('Símbolo de la unidad (mg, ml, %, etc.)');
            $table->text('description')->nullable();
            $table->string('type', 20)->default('mass')->comment('Tipo: mass, volume, percentage, etc.');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('name');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('concentration_units');
    }
};
