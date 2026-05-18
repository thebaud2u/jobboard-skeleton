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
		Schema::create('subscriptions', function (Blueprint $table) {
			$table->id();
			$table->string('checkout_session_id')->nullable();
			$table->foreignId('user_id')->constrained()->onDelete('cascade');
			$table->foreignId('offer_id')->constrained()->onDelete('cascade');
			$table->integer('quantity');
			$table->integer('remaining_quantity');
			$table->date('end_date')->nullable();
			$table->json('values')->nullable();
			$table->string('from')->default('Stripe');
			$table->boolean('synchronized_with_stripe')->default(true);
			$table->text('comment')->nullable();
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
		Schema::dropIfExists('subscriptions');
	}
};
