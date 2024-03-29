<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationreviewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('accommodation_id')->constrained()->cascadeOnDelete();
            $table->string('customer');
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->text('review');
            $table->integer('star');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('accommodationreviews');
    }
}
