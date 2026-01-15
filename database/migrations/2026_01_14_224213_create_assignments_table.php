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
    Schema::create('assignments', function (Blueprint $table) {
        $table->id();

        $table->foreignId('asset_id')->constrained('assets');
        $table->foreignId('custodian_id')->constrained('custodians');
        $table->foreignId('location_id')->constrained('locations');

        $table->enum('tipo_movimiento', ['ASIGNACION', 'REASIGNACION', 'TRASLADO'])->default('ASIGNACION');
        $table->date('fecha_asignacion')->default(DB::raw('CURRENT_DATE'));
        $table->text('observaciones')->nullable();

        $table->foreignId('user_id')->constrained('users'); // quién registró el movimiento

        $table->timestamps();
    });
}


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assignments');
    }
};
