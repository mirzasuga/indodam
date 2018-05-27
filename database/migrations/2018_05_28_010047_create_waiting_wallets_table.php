<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWaitingWalletsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('waiting_wallets', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('persentase');
            $table->unsignedDecimal('balance_dam', 10, 2)->default(0);
            $table->unsignedDecimal('amount', 10, 2)->default(0);

            $table->integer('wallet_id')->unsigned();
            $table->foreign('wallet_id')->references('id')->on('wallets');

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
        Schema::dropForeign('waiting_wallets_wallet_id_foreign');
        Schema::dropIfExists('waiting_wallets');
    }
}
