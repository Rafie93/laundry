<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

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
            $table->id();
            $table->integer('outlet_id');
            $table->string('number')->unique();
            $table->string('customer_id');
            $table->datetime('date_entry');
            $table->datetime('date_complete')->nullable();
            $table->datetime('date_taken')->nullable();
            $table->datetime('date_pay')->nullable();
            $table->integer('subtotal');
            $table->integer('discount');
            $table->integer('additional_cost');
            $table->integer('is_discount')->default(0);
            $table->integer('nominal_discount')->default(0);
            $table->integer('discount_type')->nullable();
            $table->integer('grand_total');
            $table->integer('estimated_time')->default(1);
            $table->string('estimated_type')->default('day');
            $table->string('parfume')->nullable();
            $table->string('rak')->nullable();
            $table->string('voucher_user')->nullable();
            $table->string('notes')->nullable();
            $table->integer('is_down_payment')->default(0);
            $table->integer('nominal_down_payment')->default(0);
            $table->integer('remainder')->default(0);
            $table->string('metode_payment')->nullable();
            $table->integer('status_payment')->default(0);
            $table->integer('status_order')->default(0);
            $table->text('items')->nullable();
            $table->integer('creator_id');
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
