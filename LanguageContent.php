<?php namespace App\Modules\Language;

use Illuminate\Database\Eloquent\Model;

class LanguageContent extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'language_contents';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['title', 'value', 'item_id', 'item_type'];

	/**
	 * Get the language content translations.
	 * 
	 * @return collection
	 */
	public function translations()
	{
		return $this->hasMany('App\Modules\Language\Translations', 'language_content_id');
	}

	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the translations related 
		 * to the deleted language content.
		 */
		LanguageContent::deleting(function($languageContent)
		{
			$languageContent->translations()->delete();
		});
	}
}
