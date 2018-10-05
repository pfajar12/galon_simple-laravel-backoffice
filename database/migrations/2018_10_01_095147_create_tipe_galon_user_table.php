<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTipeGalonUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tipe_galon_user', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id')->comment('from users table');
            $table->integer('galon_type_id')->comment('from tipe_galon table');
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
        Schema::dropIfExists('tipe_galon_user');
    }
}
