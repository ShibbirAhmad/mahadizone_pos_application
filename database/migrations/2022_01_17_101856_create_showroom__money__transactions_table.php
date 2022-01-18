<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShowroomMoneyTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('showroom_money_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('showroom_id');
            $table->string('amount');
            $table->string('transaction_id')->nullable();
            $table->string('paid_by');
            $table->string('status')->default(0);
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
        Schema::dropIfExists('showroom_money_transactions');
    }
}
