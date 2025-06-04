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
        Schema::create('ratings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('project_id')->constrained()->onDelete('cascade');
            $table->foreignId('rater_id')->constrained('users')->onDelete('cascade'); // quem avalia
            $table->foreignId('rated_id')->constrained('users')->onDelete('cascade'); // quem é avaliado
            $table->tinyInteger('score')->unsigned(); // 1-5
            $table->text('comment')->nullable();
            $table->string('type'); // 'client_to_freelancer' ou 'freelancer_to_client'
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ratings');
    }
};
