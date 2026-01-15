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
    Schema::create('maintenances', function (Blueprint $table) {
        $table->id();

        $table->foreignId('asset_id')->constrained('assets');
        $table->enum('tipo', ['PREVENTIVO', 'CORRECTIVO'])->default('CORRECTIVO');

        $table->date('fecha_inicio')->default(DB::raw('CURRENT_DATE'));
        $table->date('fecha_fin')->nullable();

        $table->string('proveedor_tecnico', 150)->nullable();
        $table->decimal('costo', 12, 2)->nullable();

        $table->text('descripcion_falla')->nullable();
        $table->text('trabajo_realizado')->nullable();

        $table->enum('estado', ['ABIERTO', 'EN_PROCESO', 'FINALIZADO'])->default('ABIERTO');

        $table->foreignId('user_id')->constrained('users');

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('maintenances');
    }
};
