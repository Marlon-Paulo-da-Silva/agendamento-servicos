<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSettingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->id(); // Cria a coluna 'id' como chave primária auto-incremental
            $table->unsignedBigInteger('user_id'); // Coluna para armazenar o ID do usuário
            $table->string('company')->nullable(); // Nome da empresa
            $table->string('address')->nullable(); // Endereço
            $table->string('city')->nullable(); // Cidade
            $table->string('zip')->nullable(); // CEP
            $table->string('site_email')->nullable(); // E-mail do site
            $table->string('site_phone')->nullable(); // Telefone do site
            $table->integer('booking')->default(4); // Número de reservas
            $table->string('currency_sign')->default('$'); // Símbolo da moeda
            $table->integer('area_code')->default(15); // Código de área
            $table->integer('currency_format')->default(1); // Formato da moeda
            $table->timestamps(); // Colunas de controle de criação e atualização

            // Adiciona a chave estrangeira para a tabela 'users'
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('settings');
    }
}
