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
				$table->increments('id');
				$table->string('title');
				$table->integer('item_id');
				$table->string('item_type');
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