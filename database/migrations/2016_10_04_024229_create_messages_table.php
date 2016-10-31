<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
				->index();
            $table->unsignedInteger('recipient_id')
				->index();
			$table->unsignedInteger('conversation_id')
				->index();
            $table->text('body');
			$table->foreign('user_id')
				->references('id')
				->on('users');
			$table->foreign('recipient_id')
				->references('id')
				->on('users');
			$table->foreign('conversation_id')
				->references('id')
				->on('conversations');
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
        Schema::dropIfExists('messages');
    }
}
