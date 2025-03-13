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
            $table->string('mail')->nullable()->change();
            $table->longText('password')->nullable()->change();
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
            $table->string('mail')->nullable(false)->change();
            $table->longText('password')->nullable(false)->change();
        });
    }
};
