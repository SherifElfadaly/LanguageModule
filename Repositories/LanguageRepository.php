<?php namespace App\Modules\Language\Repositories;

use App\AbstractRepositories\AbstractRepository;

class LanguageRepository extends AbstractRepository
{
	protected function getModel()
	{
		return 'App\Modules\Language\Language';
	}

	protected function getRelations()
	{
		return ['languageContentData'];
	}

	public function getLanguageByKey($key)
	{
		return $this->findBy('key', $key)[0] ?: $this->getDefaultLanguage();
	}

	public function getDefaultLanguage()
	{
		return $this->findBy('is_default', '1')[0];
	}

	public function createLanguage($data)
	{
		if($data['is_default'])  $this->resetDefaultLanguage();
		return $this->create($data);
	}

	public function updatetLanguage($id, $data)
	{
		$language = $this->find($id);

		if($language->is_default)  $this->resetDefaultLanguage();
		return $this->update($id, $data);
	}

	public function getLanguages($obj)
	{
		return $obj->languages;
	}

	public function languageIsActive($id)
	{
		return	$this->find($id)->is_active;
	}

	public function languageIsDefault($id)
	{
		return	$this->find($id)->is_default;
	}

	/**
	  * Enable or disaple Language.
	  * @param  integer $id The id of the language.
	  * @return void
	  */
	public function changeActive($id)
	{
		$language = $this->find($id);

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
		$language = $this->find($id);

		if ($this->languageIsDefault($id) === 'True')
		{
			$language->is_default = 0;
		}
		else
		{
			$this->resetDefaultLanguage();
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
