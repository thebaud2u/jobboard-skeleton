<?php

use Cmgmyr\Messenger\Models\Models;
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
		Schema::create(Models::table('messages'), function (Blueprint $table) {
			$table->increments('id');
			$table->integer('thread_id')->unsigned();
			$table->integer('user_id')->unsigned();
			$table->text('body')->nullable();
			$table->string('file')->nullable();
			$table->boolean('is_read')->default(false);
			$table->boolean('automated')->default(false);
			$table->json('values')->nullable();
			$table->timestamps();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists(Models::table('messages'));
	}
};
