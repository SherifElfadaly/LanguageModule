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
		foreach (\InstallationRepository::getModuleParts('language') as $modulePart) 
		{
			if ($modulePart === 'LanguageContents') 
			{
				\AclRepository::insertDefaultItemPermissions(
					$modulePart->part_key, 
					$modulePart->id, 
					[
					'admin'   => ['show', 'add', 'delete'],
					'manager' => ['show', 'add']
					]);
			}
			else
			{
				\AclRepository::insertDefaultItemPermissions(
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
		foreach (\InstallationRepository::getModuleParts('language') as $modulePart) 
		{
			\AclRepository::deleteItemPermissions($modulePart->part_key);
		}
	}
}