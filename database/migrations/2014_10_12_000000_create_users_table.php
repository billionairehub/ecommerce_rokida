<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->string('address')->nullable();
            $table->string('avatar')->nullable();
            $table->string('birth_day')->nullable();
            $table->string('email')->unique();
            $table->string('expired_verification')->nullable();
            $table->string('gender')->default(0);
            $table->string('name');
            $table->string('phone')->unique()->nullable();;
            $table->string('phone_verifed')->nullable();
            $table->string('shop')->nullable();;
            $table->string('verifiation_code')->nullable();
            $table->string('zip')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
