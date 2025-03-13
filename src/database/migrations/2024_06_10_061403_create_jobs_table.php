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
        Schema::create('jobs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts')->nullable();
            $table->bigInteger('reserved_at')->nullable();
            $table->bigInteger('available_at')->nullable();
            $table->bigInteger('created_at')->change();
            $table->bigInteger('updated_at')->nullable()->change();
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('jobs', function (Blueprint $table) {
            $table->timestamp('created_at')->useCurrent()->change();
            $table->bigInteger('updated_at')->nullable(false)->change();
        });
        Schema::dropIfExists('jobs');
    }
};
