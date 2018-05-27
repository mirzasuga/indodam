<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->string('phone')->nullable()->unique();
            $table->string('city');
            $table->string('address')->nullable();
            $table->unsignedDecimal('wallet', 10, 2)->default(0);
            $table->unsignedDecimal('wallet_edinar', 10, 2)->default(0);
            $table->string('username_edinar')->nullable()->unique();
            $table->string('indodax_email')->nullable()->unique();
            $table->string('referral_code')->nullable();
            $table->string('data_brand_key')->nullable()->unique();
            $table->string('cloud_link')->nullable();
            $table->date('cloud_start_date')->nullable();
            $table->date('cloud_end_date')->nullable();
            $table->string('notes')->nullable();
            $table->unsignedTinyInteger('package_id')->nullable();
            $table->unsignedTinyInteger('role_id');
            $table->unsignedInteger('sponsor_id');
            $table->boolean('is_active')->default(1);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
}
