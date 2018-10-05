<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->comment('from users table');
            $table->integer('galon_provider_id')->comment('from users table');
            $table->date('order_date');
            $table->integer('galon_type_id')->comment('from galon_type table');
            $table->integer('qty');
            $table->longText('delivered_address')->comment('alamat pengantaran');
            $table->string('delivered_lat')->comment('lat pengantaran');
            $table->string('delivered_long')->comment('long pengantaran');
            $table->integer('status')->comment('1: done; -1: canceled;');
            $table->longText('reason_for_canceling')->nullable();
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
        Schema::dropIfExists('order_log');
    }
}
