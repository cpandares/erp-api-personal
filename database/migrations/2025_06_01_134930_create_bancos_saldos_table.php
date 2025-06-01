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
        Schema::create('bancos_saldos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre_banco', 100)->nullable();
            $table->string('numero_cuenta', 50)->nullable();
            $table->decimal('saldo', 15, 2)->default(0.00);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bancos_saldos');
    }
};
