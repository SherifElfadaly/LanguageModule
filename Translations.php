<?php namespace App\Modules\Language;

use Illuminate\Database\Eloquent\Model;

class Translations extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'translations';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['key', 'value', 'language_id', 'language_content_id'];

	/**
	 * Get the translation language content.
	 * 
	 * @return collection
	 */
	public function languageContent()
	{
		return $this->belongsTo('App\Modules\Language\LanguageContent');
	}

	/**
	 * Get the translation language.
	 * 
	 * @return collection
	 */
	public function language()
	{
		return $this->belongsTo('App\Modules\Language\Language');
	}
}
