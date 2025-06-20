<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->id(); // Chave primária (id_cliente)
            $table->unsignedBigInteger('user_id'); // Relacionamento com a tabela users
            $table->timestamps();
            $table->string('company_name')->nullable(); // Nome da empresa
            $table->string('phone')->nullable(); // Telefone de contato
            // Chave estrangeira para usuários
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
