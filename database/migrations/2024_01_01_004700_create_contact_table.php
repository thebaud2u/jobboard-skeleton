<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\ContactTypes;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('contacts', function (Blueprint $table) {
			$table->id();
			$table->string('object')->nullable();
			$table->string('firstname');
			$table->string('lastname');
			$table->string('phone');
			$table->string('email');
			$table->text('body');
			$table->string('file')->nullable();
			$table->string('element')->nullable();
			$table->string('state')->default(ContactTypes::Contact->value);
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
		Schema::dropIfExists('contact');
	}
};
