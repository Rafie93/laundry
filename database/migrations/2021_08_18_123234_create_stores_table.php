<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('outlet', function (Blueprint $table) {
            $table->id();
            $table->integer('merchant_id');
            $table->string('code')->unique();
            $table->string('name');
            $table->string('phone');
            $table->string('email');
            $table->integer('city_id')->nullable();
            $table->integer('district_id')->nullable();
            $table->string('address')->nullable();
            $table->string('logo')->nullable();
            $table->double('latitude')->default(0.0);
            $table->double('longitude')->default(0.0);
            $table->string('slug')->nullable();
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('outlet');
    }
}
