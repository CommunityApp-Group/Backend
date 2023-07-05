<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodations', function (Blueprint $table) {
            $table->uuid('id')->primary()->unique();
            $table->foreignUuid('user_id')->constrained()->cascadeOnDelete();
            $table->string('title')->unique();
            $table->double('accommodation_price', 50, 2);
            $table->enum('type', ['rent', 'shortlet']);
            $table->string('accommodation_image')->nullable();
            $table->integer('bedroom')->nullable();
            $table->integer('bathroom')->nullable();
            $table->string('state');
            $table->string('city');
            $table->string('address');
            $table->string('lga');
            $table->string('category_name');
            $table->text('description');
            $table->text('nearby')->nullable();
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
        Schema::dropIfExists('accommodations');
    }
}
