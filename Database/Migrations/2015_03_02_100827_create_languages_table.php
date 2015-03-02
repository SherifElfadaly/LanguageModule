<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('languages'))
		{
			Schema::create('languages', function(Blueprint $table) {
				$table->increments('id');
				$table->string('key', 3)->unique();
				$table->string('title', 150);
				$table->string('description');
				$table->string('flag', 100);
				$table->boolean('is_active')->default(0);
				$table->boolean('is_default')->default(0);
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
		if (Schema::hasTable('languages'))
		{
			Schema::drop('languages');
		}
	}
}