<?php namespace App\Modules\Language\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;

class LanguageRepository extends AbstractRepository
{	
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Language\Language';
	}

	/**
	 * Return the module relations.
	 * 
	 * @return array
	 */
	protected function getRelations()
	{
		return ['translations'];
	}

	/**
	 * Return the language with the specified key ,
	 * if not found return the default language.
	 * 
	 * @param  string $key
	 * @return object
	 */
	public function getLanguageByKey($key)
	{
		return $this->first('key', $key) ?: $this->getDefaultLanguage();
	}

	/**
	 * Return the default language.
	 * 
	 * @return object
	 */
	public function getDefaultLanguage()
	{
		return $this->first('is_default', '1');
	}

	/**
	 * Create new language and reset all default 
	 * language if the created lanuage is set to
	 * default.
	 * 
	 * @param  array $data
	 * @return object
	 */
	public function createLanguage($data)
	{
		if($data['is_default'])  $this->resetDefaultLanguage();
		return $this->create($data);
	}

	/**
	 * Update specified language and reset all default 
	 * language if the specified lanuage is set to
	 * default.
	 * 
	 * @param  integer $id
	 * @param  array   $data
	 * @return integer       affected rows
	 */
	public function updatetLanguage($id, $data)
	{
		$language = $this->find($id);

		if($language->is_default)  $this->resetDefaultLanguage();
		return $this->update($id, $data);
	}

	/**
	 * Check if the language is active or not.
	 * 
	 * @param  integer $id
	 * @return boolean
	 */
	public function languageIsActive($id)
	{
		return	$this->find($id)->is_active;
	}

	/**
	 * Check if the language is default or not.
	 * 
	 * @param  integer $id
	 * @return boolean
	 */
	public function languageIsDefault($id)
	{
		return	$this->find($id)->is_default;
	}

	/**
	  * Enable or disable Language.
	  * 
	  * @param  integer $id
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
	  * 
	  * @param  integer $id
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
	  * 
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
