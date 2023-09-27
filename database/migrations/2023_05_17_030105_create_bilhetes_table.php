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
        Schema::create('bilhetes', function (Blueprint $table) {
            $table->id();
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
        Schema::dropIfExists('bilhetes');
    }
};
