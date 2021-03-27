<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOtpsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('otps', function (Blueprint $table) {
            $table->id();
            $table->string('encodedKey')->unique()->index()->nullable();
            $table->string('parentEncodedKey')->index();
            $table->string('digit')->nullable();
            $table->dateTime('expires_at')->nullable();
            $table->timestamps();

            $table->foreign('parentEncodedKey')->references('encodedKey')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('otps');
    }
}
