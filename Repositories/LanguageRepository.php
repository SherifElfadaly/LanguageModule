<?php namespace App\Modules\Language\Repositories;

use App\Modules\Language\Language;

class LanguageRepository
{
	public function getAllLanguages()
	{
		return Language::all();
	}

	public function getLanguage($id)
	{
		return Language::find($id);
	}

	public function createLanguage($data)
	{
		return Language::create($data);
	}

	public function updatetLanguage($id, $data)
	{
		$language = $this->getLanguage($id);
		return $language->update($data);
	}

	public function deleteLanguage($id)
	{	
		$language = $this->getLanguage($id);
		return $language->delete();
	}

	public function getLanguages($obj)
	{
		return $obj->languages;
	}

	public function addLanguages($obj, $data)
	{
		$this->deleteLanguages($obj);
		return $obj->languages()->attach($data);
	}

	public function deleteLanguages($obj)
	{
		return $obj->languages()->detach();
	}

	public function languageIsActive($id)
	{
		return	$this->getLanguage($id)->is_active;
	}
}
