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
        Schema::create('autorization_token', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('token');
            $table->boolean('status');
            $table->unsignedBigInteger('id_client')->nullable();
            $table->foreign('id_client')->references('id')->on('client')->onDelete('cascade');
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
        Schema::dropIfExists('autorization_token', function (Blueprint $table) {
            $table->dropConstrainedForeignId('id_client');
        });
        Schema::dropIfExists('autorization_token');
    }
};