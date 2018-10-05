<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->integer('role')->comment('1: super admin; 2: admin; 3: galon provider; 4: client');
            $table->integer('status')->comment('1: active; 0: not active; -1: suspended');
            $table->integer('deposit')->default(0);
            $table->longText('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('business_license_photo')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
