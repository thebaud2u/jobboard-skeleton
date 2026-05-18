<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\ArticleStates;

return new class extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('articles', function (Blueprint $table) {
			$table->id();
			$table->foreignId('admin_id')->constrained();
			$table->foreignId('section_id')->constrained();
			$table->foreignId('sub_section_id')->constrained();
			$table->foreignId('article_author_id')->constrained();
			$table->string('title');
			$table->string('slug');
			$table->json('values');
			$table->text('header');
			$table->text('body');
			$table->dateTime('start_publication_date')->nullable();
			$table->dateTime('end_publication_date')->nullable();
			$table->boolean('in_selection')->default(false);
			$table->string('state')->default(ArticleStates::Draft->value);
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
		Schema::dropIfExists('articles');
	}
};
