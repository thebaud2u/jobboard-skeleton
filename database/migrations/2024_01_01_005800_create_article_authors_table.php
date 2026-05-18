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
		Schema::create('article_authors', function (Blueprint $table) {
			$table->id();
			$table->string('name')->nullable();
			$table->string('slug')->nullable();
			$table->string('firstname', length: 125)->nullable();
			$table->string('lastname', length: 125)->nullable();
			$table->json('values');
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
		Schema::dropIfExists('article_authors');
	}
};
