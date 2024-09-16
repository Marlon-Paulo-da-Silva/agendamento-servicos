<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhoneAreaCodesTable extends Migration
{
    public function up()
    {
        Schema::create('phone_area_codes', function (Blueprint $table) {
            $table->id();
            $table->string('area_code');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('phone_area_codes');
    }
}
