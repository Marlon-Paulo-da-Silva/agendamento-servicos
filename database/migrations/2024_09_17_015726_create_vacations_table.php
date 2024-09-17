<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVacationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('vacations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // Relacionado ao usuário
            $table->unsignedBigInteger('user_res');
            $table->date('date_from')->nullable(); // Data de início das férias
            $table->date('date_to')->nullable(); // Data de término das férias
            $table->timestamps();

            // Chaves estrangeiras
            $table->foreign('user_res')->references('id')->on('profiles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('vacations');
    }
}
