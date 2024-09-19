<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->string('surname');
            $table->string('email')->unique();
            $table->string('phone');
            $table->integer('area_code');
            $table->unsignedBigInteger('user_res')->nullable();
            $table->timestamps();

            // Relacionamentos
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_res')->references('id')->on('users')->onDelete('cascade');

            // Adicionando o índice FULLTEXT
            $table->fullText(['name', 'surname']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customers');
    }
}
