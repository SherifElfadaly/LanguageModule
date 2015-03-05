<?php namespace App\Modules\Language;

use Illuminate\Database\Eloquent\Model;

class LanguageContentData extends Model {

	protected $table    = 'language_content_data';
	protected $fillable = ['key', 'value', 'language_id', 'language_content_id'];

	public function languageContent()
	{
		return $this->belongsTo('App\Modules\Language\LanguageContent');
	}

	public function language()
	{
		return $this->belongsTo('App\Modules\Language\Language');
	}
}
