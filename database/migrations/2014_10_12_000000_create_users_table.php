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
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('phone',14)->unique();
            $table->string('password');
            $table->string('gender')->nullable();
            $table->date('birthday')->nullable();
            $table->integer('status')->default(0)->comments('0:belum aktif, 1: aktif, 2:di non aktifkan');
            $table->timestamp('email_verified_at')->nullable();
            $table->integer('poin')->default(0);
            $table->string('level');
            $table->string('fcm_token')->nullable();
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
