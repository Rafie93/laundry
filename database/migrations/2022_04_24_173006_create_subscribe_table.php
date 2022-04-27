<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscribeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subscribe', function (Blueprint $table) {
            $table->id();
            $table->string('number',100)->unique();
            $table->integer('merchant_id');
            $table->integer('user_id');
            $table->integer('package_member_id');
            $table->integer('amount');
            $table->integer('status');
            $table->datetime('date');
            $table->string('payment_link')->nullable();
            $table->string('payment_status')->nullable();
            $table->string('payment_token')->nullable();
            $table->string('customer_name')->nullable();
            $table->string('customer_phone')->nullable();
            $table->string('customer_email')->nullable();

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
        Schema::dropIfExists('subscribe');
    }
}
