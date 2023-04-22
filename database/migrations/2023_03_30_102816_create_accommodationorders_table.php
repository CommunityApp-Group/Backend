<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAccommodationordersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('accommodation_orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('accommodation_id')->constrained()->cascadeOnDelete();
            $table->enum('status', ['pending','processing','completed','canceled'])->default('pending');
            $table->boolean('is_paid')->default(false);
            $table->enum('payment_method', ['cash_on_delivery'])->default('cash_on_delivery');
            $table->string('notes')->nullable();
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
        Schema::dropIfExists('accommodation_orders');
    }
}
