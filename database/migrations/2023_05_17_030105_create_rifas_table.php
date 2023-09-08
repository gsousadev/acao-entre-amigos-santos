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
        Schema::create('rifas', function (Blueprint $table) {
            $table->id();
            $table->string('tipo_presente');
            $table->float('valor_dinheiro')->nullable();
            $table->string('tamanho_fralda')->nullable();
            $table->string('nome_convidado');
            $table->string('email_convidado');
            $table->string('telefone_convidado');
            $table->boolean('validada')->default(false);
            $table->foreignId('santo_id')->constrained()->unique();
            $table->timestamp('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rifas');
    }
};
