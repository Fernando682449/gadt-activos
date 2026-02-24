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
    Schema::table('assets', function (Blueprint $table) {
        $table->foreignId('category_id')->nullable()->constrained()->nullOnDelete();
        $table->foreignId('brand_id')->nullable()->constrained()->nullOnDelete();

        // variable: letras/números/guiones (ej: OC-2026-001)
        $table->string('purchase_order_number', 100)->nullable();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('assets', function (Blueprint $table) {
            //
        });
    }
};
