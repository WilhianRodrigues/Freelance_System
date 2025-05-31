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
        $table->foreignId('project_id')->constrained();
        $table->foreignId('freelancer_id')->constrained('users');
        $table->text('message');
        $table->decimal('budget', 10, 2);
        $table->dateTime('deadline');
        $table->string('status')->default('pending');
        $table->timestamps();
        });
    }


    public function down()
    {
        Schema::dropIfExists('proposals');
    }
}