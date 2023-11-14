<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserKycsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_kycs', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('status');
            $table->unsignedTinyInteger('account_type');
            $table->string('company_name')->nullable();
            $table->string('registered_office')->nullable();
            $table->string('business_address')->nullable();
            $table->string('registration_number')->nullable();
            $table->string('name_of_the_representative')->nullable();
            $table->string('country_code')->nullable();
            $table->string('tax_id_number')->nullable();
            $table->string('email');
            $table->string('phone_number');
            $table->text('message')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('user_kycs', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
        });

        Schema::dropIfExists('user_kycs');
    }
}
