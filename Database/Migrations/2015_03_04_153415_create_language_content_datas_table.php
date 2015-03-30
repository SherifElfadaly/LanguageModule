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
				$table->bigIncrements('id');	
				$table->string('key', 100)->index();
				$table->text('value');

				$table->bigInteger('language_content_id')->unsigned();
				$table->foreign('language_content_id')->references('id')->on('language_contents');

				$table->bigInteger('language_id')->unsigned();
				$table->foreign('language_id')->references('id')->on('languages');

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