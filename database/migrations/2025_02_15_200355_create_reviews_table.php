<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Executa as migrations.
     */
    public function up(): void
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Chave primária (id_review)
            $table->unsignedBigInteger('reviewer_id'); // Usuário que fez a avaliação
            $table->unsignedBigInteger('reviewed_id'); // Usuário que está sendo avaliado
            $table->unsignedBigInteger('project_id'); // Referência ao projeto relacionado
            $table->tinyInteger('rating')->unsigned(); // Nota de 1 a 5
            $table->text('comment')->nullable(); // Comentário opcional
            $table->timestamps(); // Criado em / Atualizado em

            // Chaves estrangeiras
            $table->foreign('reviewer_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('reviewed_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        });
    }

    /**
     * Reverte as migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
