<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWebpayPlusMallOrdersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webpay_plus_mall_orders', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('total_amount');
            $table->longText('transaction_detail')->nullable();
            $table->string('status');
            $table->unsignedBigInteger('order_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('webpay_plus_orders');
    }
}
