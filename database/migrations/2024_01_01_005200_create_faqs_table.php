<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\FaqStates;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faqs', function (Blueprint $table) {
			$table->id();
			$table->foreignId('admin_id')->constrained();
			$table->string('name');
			$table->string('slug');
			$table->string('state')->default(FaqStates::Draft->value);
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
		Schema::dropIfExists('faqs');
	}
};
