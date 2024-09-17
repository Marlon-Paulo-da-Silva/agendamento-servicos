<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->unsignedBigInteger('user_id'); // Reference to the user
            $table->string('name'); // Name of the reviewer
            $table->text('review'); // Review content
            $table->integer('vote'); // Star rating (vote)
            $table->tinyInteger('status')->default(0); // Review status (e.g., 1 = approved, 0 = waiting)
            $table->timestamps(); // Created_at and Updated_at

            // Definindo uma foreign key para o user_id
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
        Schema::dropIfExists('reviews');
    }
}
