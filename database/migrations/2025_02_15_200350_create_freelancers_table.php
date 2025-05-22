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
        Schema::create('freelancers', function (Blueprint $table) {
            $table->id(); // Chave primária
            $table->unsignedBigInteger('user_id'); // Relacionamento com a tabela users
            $table->string('profession')->default('Não especificado');  // Valor padrão
            $table->text('bio')->nullable(); // Pequena biografia
            $table->text('skills')->nullable(); // Habilidades do freelancer
            $table->string('portfolio_url')->nullable(); // Link para portfólio
            $table->decimal('hourly_rate', 8, 2)->nullable(); // Valor por hora
            $table->integer('rating')->default(0); // Avaliação média
            $table->timestamps();

            // Chave estrangeira para usuários
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('freelancers');
    }
};
