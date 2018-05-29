<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWithdrawRequestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('withdraw_requests', function (Blueprint $table) {

            $table->increments('id');
            $table->string('status')->default('request'); //request, verified, accepted
            $table->unsignedDecimal('amount', 10, 2)->default(0);
            $table->ipAddress('sender_ip');
            $table->ipAddress('acc_ip')->nullable();

            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->integer('admin_id')->nullable();
            $table->datetimeTz('requested_at');
            $table->datetimeTz('verified_at')->nullable();
            $table->datetimeTz('accepted_at')->nullable();

            $table->string('request_token',255);


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

        Schema::dropForeign('withdraw_request_user_id_foreign');
        Schema::dropIfExists('withdraw_requests');
    }
}
