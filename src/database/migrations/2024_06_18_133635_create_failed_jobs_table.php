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
        Schema::dropIfExists('failed_jobs');
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->unsignedTinyInteger('attempts')->nullable();
            $table->bigInteger('reserved_at')->nullable();
            $table->bigInteger('available_at')->nullable();
            $table->timestamp('failed_at')->useCurrent();
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
        Schema::table('failed_jobs', function (Blueprint $table) {
            $table->timestamp('created_at')->useCurrent()->change();
            $table->bigInteger('updated_at')->nullable(false)->change();
        });
        Schema::dropIfExists('failed_jobs');
    }
};
