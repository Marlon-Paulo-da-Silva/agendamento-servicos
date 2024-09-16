<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profiles', function (Blueprint $table) {
            $table->id();  // ID da tabela
            $table->unsignedBigInteger('user_id');  // Chave estrangeira relacionada à tabela users
            $table->string('profile_image')->nullable();  // Imagem de perfil (pode ser nulo)
            $table->string('name');  // Nome principal
            $table->string('surname')->nullable();  // Sobrenome (pode ser nulo)
            $table->string('occupation')->nullable();  // Ocupação
            $table->string('area_code')->nullable();  // Código de área do telefone
            $table->string('phone')->nullable();  // Telefone
            $table->text('about')->nullable();  // Texto "Sobre você" (pode ser nulo)
            $table->boolean('include_profile')->default(false);  // Incluir perfil como parte da equipe
            $table->timestamps();  // Campos de criação e atualização automática

            // Definindo a chave estrangeira
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
        Schema::dropIfExists('profiles');
    }
}
