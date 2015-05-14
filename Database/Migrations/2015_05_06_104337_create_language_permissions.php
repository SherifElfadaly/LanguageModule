<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLanguagePermissions extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		foreach (\CMS::CoreModuleParts()->getModuleParts('language') as $modulePart) 
		{
			if ($modulePart === 'LanguageContents') 
			{
				\CMS::permissions()->insertDefaultItemPermissions(
					                 $modulePart->part_key, 
					                 $modulePart->id, 
					                 [
						                 'admin'   => ['show', 'add', 'delete'],
						                 'manager' => ['show', 'add']
					                 ]);
			}
			else
			{
				\CMS::permissions()->insertDefaultItemPermissions(
					                 $modulePart->part_key, 
					                 $modulePart->id, 
					                 [
						                 'admin'   => ['show', 'add', 'edit', 'delete'],
						                 'manager' => ['show', 'edit']
					                 ]);
			}
		}
	}

	/**
	 * Reverse the migration.
	 *
	 * @return void
	 */
	public function down()
	{
		foreach (\CMS::CoreModuleParts()->getModuleParts('language') as $modulePart) 
		{
			\CMS::permissions()->deleteItemPermissions($modulePart->part_key);
		}
	}
}