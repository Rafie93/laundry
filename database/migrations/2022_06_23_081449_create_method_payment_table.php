<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMethodPaymentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('method_payment', function (Blueprint $table) {
            $table->id();
            $table->integer('outlet_id')->nullable();
            $table->string('name');
            $table->string('type')->comment('Tunai,Transfer,E-Wallet');
            $table->string('logo')->nullable();
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
        Schema::dropIfExists('method_payment');
    }
}
