<?php namespace App\Modules\Language\Traits;

use App\Modules\Language\Language;

trait LanguageTrait{
	
	public function getAllLanguages()
	{
		return Language::with('languageContentData')->get();
	}

	public function getLanguage($id)
	{
		return Language::find($id);
	}

	public function getLanguageByKey($key)
	{
		return Language::where('key', $key)->first() ?: $this->getDefaultLanguage();
	}

	public function getDefaultLanguage()
	{
		return Language::with('languageContentData')->where('is_default', '1')->first();
	}

	public function createLanguage($data)
	{
		if($data['is_default'])  $this->resetDefaultLanguage();
		return Language::create($data);
	}

	public function updatetLanguage($id, $data)
	{
		$language = $this->getLanguage($id);

		if($language->is_default)  $this->resetDefaultLanguage();
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

	public function languageIsActive($id)
	{
		return	$this->getLanguage($id)->is_active;
	}

	public function languageIsDefault($id)
	{
		return	$this->getLanguage($id)->is_default;
	}

	/**
	  * Enable or disaple Language.
	  * @param  integer $id The id of the language.
	  * @return void
	  */
	public function changeActive($id)
	{
		$language = $this->getLanguage($id);

		if ($this->languageIsActive($id) === 'True')
		{
			$language->is_active = 0;
		}
		else
		{
			$language->is_active = 1;
		}
		$language->update();
	}

	/**
	  * Set language to default.
	  * @param  integer $id The id of the language.
	  * @return void
	  */
	public function changeDefault($id)
	{
		$this->resetDefaultLanguage();
		$language = $this->getLanguage($id);

		if ($this->languageIsDefault($id) === 'True')
		{
			$language->is_default = 0;
		}
		else
		{
			$language->is_default = 1;
		}
		$language->update();
	}

	/**
	  * Set no language to default.
	  * @param  integer $id The id of the language.
	  * @return void
	  */
	public function resetDefaultLanguage()
	{
		$language = $this->getDefaultLanguage();
		if($language)
		{
			$language->is_default = 0;
			$language->save();
		}
	}
}