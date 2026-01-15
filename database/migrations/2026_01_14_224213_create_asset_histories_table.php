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
    Schema::create('asset_histories', function (Blueprint $table) {
        $table->id();

        $table->foreignId('asset_id')->constrained('assets');
        $table->string('evento', 200); // texto corto
        $table->text('detalle')->nullable(); // descripción
        $table->dateTime('fecha_evento')->default(DB::raw('CURRENT_TIMESTAMP'));

        $table->foreignId('user_id')->constrained('users');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('asset_histories');
    }
};
