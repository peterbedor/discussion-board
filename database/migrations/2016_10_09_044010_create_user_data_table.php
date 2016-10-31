<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
		Schema::create('user_data', function(Blueprint $table) {
			$table->unsignedInteger('user_id');
			$table->text('about');
			$table->string('twitter');
			$table->string('linked_in');
			$table->string('github');
			$table->string('bitbucket');
			$table->dateTime('birthday');
			$table->timestamps();
			$table->foreign('user_id')
				->references('id')
				->on('users');
		});
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_data');
    }
}
