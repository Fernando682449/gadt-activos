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
    Schema::create('assets', function (Blueprint $table) {
        $table->id();

        $table->string('codigo_patrimonial', 60)->unique();
        $table->string('numero_serie', 80)->nullable();

        $table->foreignId('asset_type_id')->constrained('asset_types');
        $table->foreignId('status_id')->constrained('asset_statuses');
        $table->foreignId('location_id')->constrained('locations');

        $table->date('fecha_compra')->nullable();
        $table->decimal('costo', 12, 2)->nullable();
        $table->text('observaciones')->nullable();

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};
