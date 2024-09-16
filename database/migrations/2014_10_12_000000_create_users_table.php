<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('url')->nullable();
            $table->string('profile_image')->nullable();
            $table->string('name')->nullable();
            $table->string('surname')->nullable();
            $table->string('occupation')->nullable();
            $table->integer('area_code')->nullable();
            $table->integer('phone')->nullable();
            $table->text('about')->nullable();
            $table->boolean('include_profile')->nullable();
            $table->dateTime('valid_to')->nullable();
            $table->tinyInteger('privilege')->default(1);
            $table->unsignedBigInteger('member')->nullable();
            $table->string('template')->default('default');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
