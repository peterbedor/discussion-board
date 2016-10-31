<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserMentionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentions', function(Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id')
                ->index();
			$table->unsignedInteger('item_id')
				->index();
            $table->unsignedInteger('user_id_mentioned')
                ->index();
            $table->foreign('user_id')
                ->references('id')
                ->on('users');
            $table->foreign('user_id_mentioned')
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
        Schema::dropIfExists('mentions');
    }
}
