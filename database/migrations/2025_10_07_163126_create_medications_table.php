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
        Schema::create('medications', function (Blueprint $table) {
            $table->id();
            $table->string('commercial_name', 255);
            $table->string('generic_name', 255);
            $table->foreignId('active_ingredient_id')->constrained()->onDelete('cascade');
            $table->foreignId('concentration_unit_id')->constrained()->onDelete('restrict');
            $table->decimal('concentration', 10, 4);
            $table->foreignId('administration_route_id')->constrained()->onDelete('restrict');
            $table->string('pharmaceutical_form', 100)->comment('Forma farmacéutica: tableta, cápsula, etc.');
            $table->string('registration_number', 50)->unique()->comment('Número de registro sanitario');
            $table->string('laboratory', 255)->nullable();
            $table->text('presentation')->nullable()->comment('Presentación del medicamento');
            $table->text('indications')->nullable();
            $table->text('contraindications')->nullable();
            $table->text('warnings')->nullable();
            $table->json('storage_conditions')->nullable()->comment('Condiciones de almacenamiento en JSON');
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            
            $table->index('commercial_name');
            $table->index('generic_name');
            $table->index('active_ingredient_id');
            $table->index('registration_number');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medications');
    }
};
