<?php namespace App\Modules\Language;

use Illuminate\Database\Eloquent\Model;

class LanguageContent extends Model {

	protected $table    = 'language_contents';
	protected $fillable = ['title', 'value', 'item_id', 'item_type'];

	public function languageContentData()
	{
		return $this->hasMany('App\Modules\Language\LanguageContentData', 'language_content_id');
	}

	public static function boot()
	{
		parent::boot();

		LanguageContent::deleting(function($languageContent)
		{
			$languageContent->languageContentData()->delete();
		});
	}
}
