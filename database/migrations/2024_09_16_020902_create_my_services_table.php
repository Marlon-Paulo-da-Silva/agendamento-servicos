<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('my_services', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id'); // ID do admin
            $table->unsignedBigInteger('user_res'); // ID do cliente
            $table->unsignedBigInteger('service_id'); // ID do serviço
            $table->timestamps();

            // Definir foreign keys, assumindo que você tem tabelas users e services
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_res')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('service_id')->references('id')->on('services')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('my_services');
    }
}
