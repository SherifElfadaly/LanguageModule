<?php namespace App\Modules\Language\Facades;

use Illuminate\Support\Facades\Facade;

class LanguageRepository extends Facade
{
	protected static function getFacadeAccessor() { return 'LanguageRepository'; }
}