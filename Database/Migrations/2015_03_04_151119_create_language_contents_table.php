<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageContentsTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('language_contents'))
		{
			Schema::create('language_contents', function(Blueprint $table) {
				$table->bigIncrements('id');
				$table->string('title', 150)->index();
				$table->bigInteger('item_id')->unsigned();
				$table->string('item_type', 100)->index();
				$table->timestamps();
			});
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		if (Schema::hasTable('language_contents'))
		{
			Schema::drop('language_contents');
		}
	}
}