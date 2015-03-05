<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguageContentDatasTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if ( ! Schema::hasTable('language_content_data'))
		{
			Schema::create('language_content_data', function(Blueprint $table) {
				$table->increments('id');	
				$table->string('key');
				$table->text('value');
				$table->integer('language_content_id');
				$table->integer('language_id');
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
		if (Schema::hasTable('language_content_data'))
		{
			Schema::drop('language_content_data');
		}
	}
}