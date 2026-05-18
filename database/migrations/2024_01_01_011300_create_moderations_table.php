<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\ModerationStates;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('moderations', function (Blueprint $table) {
			$table->id();
			$table->foreignId('admin_id')->nullable()->constrained();
			$table->morphs('model');
			$table->string('state')->default(ModerationStates::Waiting->value);
			$table->string('reason')->nullable();
			$table->text('description')->nullable();
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
		Schema::dropIfExists('moderations');
	}
};
