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
            $table->string('name_github')->nullable()->unique();
            $table->string('github_id')->nullable()->unique();
            $table->string('avatar_github')->nullable();
            $table->string('github_nickname')->nullable();
            $table->string('token_github')->nullable();
        });
    }

    /** */
    public function down()
    {
        Schema::table('customers_account', function (Blueprint $table) {
            $table->dropColumn(['name_github', 'github_id', 'avatar_github', 'github_nickname', 'token_github']);
        });
    }
};
