<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackageMemberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('package_member', function (Blueprint $table) {
            $table->id();
            $table->string('package');
            $table->integer('price');
            $table->integer('duration');
            $table->enum('duration_day',['day','month','year']);
            $table->integer('maks_transaksi')->nullable();
            $table->integer('cashier')->nullable();
            $table->integer('branch')->nullable();
            $table->enum('footer',['Yes','No']);
            $table->enum('qris',['Yes','No']);
            $table->enum('report_to_wa',['Yes','No']);
            $table->enum('auto_send_nota',['Yes','No']);
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
        Schema::dropIfExists('package_member');
    }
}
