<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTariffsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_tariffs', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->onDelete('cascade')->references('id')->on('users');

            $table->unsignedBigInteger('tariff_id');
            $table->foreign('tariff_id')->references('id')->on('tariffs');

            $table->unsignedBigInteger('payment_id');
            $table->foreign('payment_id')->references('id')->on('transactions');

            $table->boolean('status')->default(false);
            $table->integer('days_end_sub')->nullable();
            $table->integer('until_limit')->default(0);

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
        Schema::dropIfExists('user_tariffs');
    }
}
