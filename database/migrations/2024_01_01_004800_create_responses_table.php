<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\ResponseStates;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('responses', function (Blueprint $table) {
			$table->id();
			$table->nullableMorphs('model');
			$table->integer('thread_id')->unsigned()->nullable();
			$table->unsignedBigInteger('from_user_id')->nullable();
			$table->unsignedBigInteger('to_user_id')->nullable();
			$table->string('state')->default(ResponseStates::Received->value);
			$table->json('values')->nullable();
			$table->timestamps();
			$table->softDeletes();

			$table->foreign('thread_id')->references('id')->on('threads')->onDelete('cascade');
			$table->foreign('from_user_id')->references('id')->on('users')->onDelete('cascade');
			$table->foreign('to_user_id')->references('id')->on('users')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('responses');
	}
};
