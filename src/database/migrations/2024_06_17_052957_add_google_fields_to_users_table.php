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
        Schema::table('customers_account', function (Blueprint $table) {
            $table->string('name_google')->nullable();
            $table->string('google_id')->nullable();
            $table->string('avatar_google')->nullable();
            $table->string('token_google')->nullable();
            $table->string('google_refresh_token')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customers_account', function (Blueprint $table) {
            $table->dropColumn(['name_google', 'google_id', 'avatar_google', 'token_google', 'google_refresh_token']);
        });
    }
};
