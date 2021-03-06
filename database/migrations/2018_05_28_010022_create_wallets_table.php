<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wallets', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedDecimal('balance_dam', 10, 2)->default(0);
            $table->unsignedDecimal('balance_edinar', 10, 2)->default(0);
            $table->unsignedDecimal('mining_balance', 10, 2)->default(0);
            $table->unsignedDecimal('merge_to_mining', 10, 2)->default(0);
            $table->unsignedDecimal('mining_income', 10, 2)->default(0);
            $table->unsignedDecimal('virtual_balance', 10, 2)->default(0);
            $table->dateTime('started_mining')->nullable();
            $table->dateTime('end_mining')->nullable();
            $table->integer('member_id')->unsigned();
            $table->foreign('member_id')->references('id')->on('users');

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
        Schema::dropForeign('wallets_member_id_foreign');
        Schema::dropIfExists('wallets');
    }
}
