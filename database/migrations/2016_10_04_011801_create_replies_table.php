<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRepliesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('replies', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
				->index();
            $table->unsignedInteger('discussion_id')
				->index();
			$table->text('body');
			$table->tinyInteger('active')
				->default(1);
			$table->foreign('user_id')
				->references('id')
				->on('users');
			$table->foreign('discussion_id')
				->references('id')
				->on('discussions');
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
        Schema::dropIfExists('replies');
    }
}
