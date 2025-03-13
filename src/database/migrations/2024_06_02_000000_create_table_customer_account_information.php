<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_account_information', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_customers_account')->nullable();
            $table->foreign('id_customers_account')->references('id')->on('customers_account')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone_number');
            $table->string('company');
            $table->timestamp('created_at');
            $table->timestamp('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_account_information', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_customers_account');
        });
        Schema::dropIfExists('customer_account_information');
    }
};