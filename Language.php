<?php namespace App\Modules\Language;

use Illuminate\Database\Eloquent\Model;

class Language extends Model {

	/**
	 * Spescify the storage table.
	 * 
	 * @var table
	 */
	protected $table    = 'languages';

	/**
	 * Specify the fields allowed for the mass assignment.
	 * 
	 * @var fillable
	 */
	protected $fillable = ['key', 'title', 'description', 'flag', 'is_active', 'is_default'];

	/**
	 * Specify what field should be castet to what.
	 * 
	 * @var casts
	 */
	protected $casts    = ['is_active' => 'boolean', 'is_default' => 'boolean'];

	/**
	 * Get True or False based on the value
	 * of is active field.
	 * 
	 * @param  boolean $value 
	 * @return string
	 */
	public function getIsActiveAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	/**
	 * Get True or False based on the value
	 * of is default field.
	 * 
	 * @param  boolean $value 
	 * @return string
	 */
	public function getIsDefaultAttribute($value)
	{
		return $value ? 'True' : 'False';
	}

	/**
	 * Get the language translations.
	 * 
	 * @return collection
	 */
	public function translations()
	{
		return $this->hasMany('App\Modules\Language\Translations', 'language_id');
	}

	public static function boot()
	{
		parent::boot();

		/**
		 * Remove the translations related 
		 * to the deleted language.
		 */
		Language::deleting(function($language)
		{
			$language->translations()->delete();
		});
	}
}
