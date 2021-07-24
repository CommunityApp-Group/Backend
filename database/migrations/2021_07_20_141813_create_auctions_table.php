<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAuctionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('auctions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('encodedKey')->unique();
            $table->string('auction_name');
            $table->string('location');
            $table->decimal('auction_price', 50, 2);
            $table->string('category_name');
            $table->text('description')->nullable();
            $table->text('auction_image')->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->foreignId('verified_by')->nullOnDelete()->nullable();
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
        Schema::dropIfExists('auctions');
    }
}
