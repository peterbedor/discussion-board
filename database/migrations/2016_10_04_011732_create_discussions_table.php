<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDiscussionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discussions', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
				->index();
            $table->unsignedInteger('channel_id')
				->index();
			$table->string('title');
			$table->string('slug');
			$table->text('body');
			$table->tinyInteger('active')
				->default(1);
			$table->foreign('user_id')
				->references('id')
				->on('users');
			$table->foreign('channel_id')
				->references('id')
				->on('channels');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('discussions');
    }
}
