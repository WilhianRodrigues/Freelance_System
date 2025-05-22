<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProposalsTable extends Migration
{
    public function up(): void
{
    Schema::create('proposals', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('project_id');
        $table->unsignedBigInteger('freelancer_id');
        $table->decimal('price', 10, 2);
        $table->integer('deadline'); // em dias
        $table->text('message');
        $table->enum('status', ['pendente', 'aceita', 'rejeitada'])->default('pendente');
        $table->timestamps();

        $table->foreign('project_id')->references('id')->on('projects')->onDelete('cascade');
        $table->foreign('freelancer_id')->references('id')->on('freelancers')->onDelete('cascade');
    });
}


    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}