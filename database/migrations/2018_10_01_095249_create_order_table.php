<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOrderTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('order', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('client_id')->comment('from user table');
            $table->integer('provider_id')->comment('from user table');
            $table->integer('galon_type')->comment('from galon_type table');
            $table->integer('qty');
            $table->longText('delivered_address')->comment('alamat pengantaran');
            $table->string('delivered_lat')->comment('lat pengantaran');
            $table->string('delivered_long')->comment('long pengantaran');
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
        Schema::dropIfExists('order');
    }
}
