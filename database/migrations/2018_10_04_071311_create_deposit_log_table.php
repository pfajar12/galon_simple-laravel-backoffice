<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDepositLogTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('deposit_log', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('depot_id')->comment('from users table; id depot galon');
            $table->integer('approved_by')->comment('from users table; id admin');
            $table->integer('deposit_amount');
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
        Schema::dropIfExists('deposit_log');
    }
}
