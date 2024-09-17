<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkTimesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_times', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('user_res')->nullable();
            $table->date('date_from');
            $table->date('date_to');
            $table->time('time_from');
            $table->time('time_to');
            $table->time('lunch_from')->nullable();
            $table->time('lunch_to')->nullable();
            $table->timestamps();

            // Foreign keys and index
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('user_res')->references('id')->on('profiles')->onDelete('cascade');
            $table->index(['user_id', 'user_res']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('work_times');
    }
}
