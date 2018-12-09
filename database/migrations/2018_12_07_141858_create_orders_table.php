<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('order_no');
            $table->integer('user_id');
            $table->string('product');
            $table->string('shipping_address');
            $table->string('shipping_code')->nullable();
            $table->integer('price');
            $table->integer('fee');
            $table->integer('total');
            $table->enum('status', ['unpaid', 'paid', 'canceled', 'failed'])->default('unpaid');
            $table->timestamp('payment_at')->nullable();
            $table->timestamp('expired_at')->nullable();
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
        Schema::dropIfExists('orders');
    }
}
