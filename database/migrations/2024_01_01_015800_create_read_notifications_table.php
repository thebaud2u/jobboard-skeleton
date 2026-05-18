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
		Schema::create('read_notifications', function (Blueprint $table) {
			$table->id();
			$table->uuid('notification_id')->nullable();
			$table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
			$table->timestamps();

			$table->foreign('notification_id')->references('id')->on('notifications')->onDelete('cascade');
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('read_notifications');
	}
};
