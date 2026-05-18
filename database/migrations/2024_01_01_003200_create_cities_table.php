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
		Schema::create('cities', function (Blueprint $table) {
			$table->id();
			$table->string('insee_code')->nullable();
			$table->string('department_code');
			$table->string('name');
			$table->string('slug');
			$table->string('zip_code');
			$table->double('gps_lat', 16, 14);
			$table->double('gps_lng', 17, 14);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('cities');
	}
};
