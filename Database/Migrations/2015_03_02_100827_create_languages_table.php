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
				$table->bigIncrements('id');
				$table->string('key', 3)->unique()->index();
				$table->string('title', 150)->index();
				$table->string('description', 255)->index();
				$table->string('flag', 100);
				$table->boolean('is_active')->default(0)->index();
				$table->boolean('is_default')->default(0)->index();
				$table->timestamps();
			});

			DB::table('languages')->insert(
				array(
					'key'         => 'en',
					'title'    	  => 'English',
					'description' => 'English Language',
					'flag'        => 'English',
					'is_active'   => 1,
					'is_default'  => 1,
					)
				);
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