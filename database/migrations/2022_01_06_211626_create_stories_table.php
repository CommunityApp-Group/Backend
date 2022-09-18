<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('encodedKey')->unique();
            $table->string('title');
            $table->string('category_name');
            $table->text('storyline')->nullable();
            $table->text('story_image')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }
    // Schema::create('users', function (Blueprint $table) {
    //     $table->id();
    //     $table->string('nom');
    //     $table->string('prénom');
    //     $table->string('direction');
    //     $table->string('email')->unique();
    //     $table->string('role')->default(0);
    //     $table->timestamp('email_verified_at')->nullable();
    //     $table->string('password');
    //     $table->foreign('direction_id')->references('id')->on('direction')->onDelete('cascade');
    //     $table->rememberToken();
    //     $table->timestamps();



    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('stories');
    }
}
