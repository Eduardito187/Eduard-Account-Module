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
        Schema::create('notifications_client', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('id_client')->nullable();
            $table->foreign('id_client')->references('id')->on('client')->onDelete('cascade');
            $table->boolean('report_day');
            $table->boolean('report_month');
            $table->boolean('alert_usage');
            $table->boolean('alert_billing');
            $table->boolean('ai');
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
        Schema::dropIfExists('notifications_client', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_client');
        });
        Schema::dropIfExists('notifications_client');
    }
};