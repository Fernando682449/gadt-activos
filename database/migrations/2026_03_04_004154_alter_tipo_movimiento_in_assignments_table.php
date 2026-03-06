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
    DB::statement("ALTER TABLE assignments MODIFY tipo_movimiento ENUM('ASIGNACION','REASIGNACION','TRASLADO','DEVOLUCION') NOT NULL");
}

public function down(): void
{
    DB::statement("ALTER TABLE assignments MODIFY tipo_movimiento ENUM('ASIGNACION','REASIGNACION','TRASLADO') NOT NULL");
}
};
