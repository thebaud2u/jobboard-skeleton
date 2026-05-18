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
		Schema::create('addresses', function (Blueprint $table) {
			$table->id();
			$table->morphs('model');
			$table->foreignId('country_id')->nullable()->constrained();
			$table->foreignId('region_id')->nullable()->constrained();
			$table->foreignId('department_id')->nullable()->constrained();
			$table->foreignId('city_id')->nullable()->constrained();
			$table->string('street')->nullable();
			$table->string('additional_1')->nullable();
			$table->string('additional_2')->nullable();
			$table->string('custom_postcode')->nullable();
			$table->string('custom_province')->nullable();
			$table->string('custom_city')->nullable();
			$table->double('gps_lat', 16, 14)->nullable();
			$table->double('gps_lng', 17, 14)->nullable();
			$table->boolean('for_moderation')->default(false);
			$table->string('collection')->nullable();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('addresses');
	}
};
