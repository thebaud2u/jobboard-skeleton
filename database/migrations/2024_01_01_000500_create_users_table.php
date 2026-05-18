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
		Schema::create('users', function (Blueprint $table) {
			$table->id();
			$table->string('customer_id')->nullable();
			$table->enum('gender', ['Mr', 'Mrs']);
			$table->string('name')->nullable();
			$table->string('slug')->nullable();
			$table->string('firstname', length: 125)->nullable();
			$table->string('lastname', length: 125)->nullable();
			$table->string('email')->unique();
			$table->string('code')->unique()->nullable();
			$table->string('password');
			$table->rememberToken();
			$table->text('other')->nullable();
			$table->string('phone')->nullable();
			$table->json('values')->nullable();
			$table->date('birth_date')->nullable();
			$table->boolean('pending')->default(false);
			$table->timestamp('email_verified_at')->nullable();
			$table->timestamp('last_logon')->nullable();
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
		Schema::dropIfExists('users');
	}
};
