<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function(Blueprint $table) {
            $table->unsignedInteger('user_id')
                ->index();
            $table->unsignedInteger('reply_id')
                ->index();
            $table->integer('points')
                ->default(0);
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('reply_id')
                ->references('id')
                ->on('replies');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points');
    }
}
