<?php namespace App\Modules\Language\Repositories;

use App\Modules\Core\AbstractRepositories\AbstractRepository;
use App\Modules\Language\Translations;

class LanguageContentRepository extends AbstractRepository
{	
	/**
	 * Return the model full namespace.
	 * 
	 * @return string
	 */
	protected function getModel()
	{
		return 'App\Modules\Language\LanguageContent';
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
	 * Get a listing of item ids belong to specified item
	 * when translation value match the given query.
	 * 
	 * @param  string $query
	 * @param  string  $item  The name of the item the 
	 *                        language content belongs to.
	 *                        ex: 'user', 'content' ....
	 * @return array
	 */
	public function search($query, $item)
	{	
		$languageContentIds = Translations::where('value', 'like', '%' . $query . '%')->lists('language_content_id');
		return $this->model->whereIn('id', $languageContentIds)->
			                 where('item_type', '=', $item)->lists('item_id');
	}

	/**
	 * Return the language content for the specified item and
	 * item id.
	 * 
	 * @param  string  $item        The name of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @param  integer $itemId      The id of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @return collection
	 */
	public function getItemLanguageContent($item, $itemId)
	{
		return $this->model->with($this->getRelations())->
		                     whereRaw('item_id=? and item_type=?', [$itemId, $item])->
		                     get();
	}
	
	/**
	 * Return the translation of the given title and language
	 * for specified item and item id.If the title isn't given 
	 * then return all translations.
	 * 
	 * @param  string  $item        The name of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @param  integer $itemId      The id of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @param  string  $languageKey
	 * @param  string  $title
	 * @return string if the title is given ,
	 *         array for all translations
	 */
	public function getTranslations($itemId, $item, $languageKey, $title = false)
	{
		if( ! $title)
		{
			$data = array();
			foreach ($this->getItemLanguageContent($item, $itemId) as $languageContent) 
			{
				$translation                   =  $languageContent->translations()->
			                                                        where('language_id', \CMS::languages()->getLanguageByKey($languageKey)->id)->
			                                                        first();
				if (is_null($translation)) 
				{
					$translation               =  $languageContent->translations()->
			                                                        where('language_id', \CMS::languages()->getDefaultLanguage()->id)->
			                                                        first();
				}
				$data[$languageContent->title] = $translation->value;
			}
			return $data;
		}
		else
		{
			$languageContent = $this->getItemLanguageContent($item, $itemId)->
			                          where('title', $title)->
			                          first();
			if (is_null($languageContent)) return '';
			
			$translation     = $languageContent->translations()->
			                                     where('language_id', \CMS::language()->getLanguageByKey($languageKey)->id)->
			                                     first();

			if (is_null($translation)) 
			{
				$translation = $languageContent->translations()->
			                                     where('language_id', \CMS::language()->getDefaultLanguage()->id)->
			                                     first();
			}
           return $translation->value;
		}
	}

	/**
	 * Perpare the language content data
	 * and insert the translations.
	 * 
	 * @param  array   $data
	 * @param  string  $item        The name of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @param  integer $itemId      The id of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @return void
	 */
	public function insertLanguageContent($data, $item, $itemId)
	{
		foreach ($data as $key => $value) 
		{
			$languageContentData['title']       = $key;
			$languageContentData['key']         = $key;
			$languageContentData['value']       = $value;
			$languageContentData['language_id'] = \CMS::languages()->getDefaultLanguage()->id;
			$this->createLanguageContent($languageContentData, $item, $itemId);
		}
	}

	/**
	 * Create or update the given translations
	 * for specified item and item id.
	 * 
	 * @param  array   $data
	 * @param  string  $item        The name of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @param  integer $itemId      The id of the item the 
	 *                              language content belongs to. 
	 *                              ex: 'user', 'content' ....
	 * @return void
	 */
	public function createLanguageContent($data, $item, $itemId)
	{
		$languageContents = $this->model->firstOrCreate([
			'title'     => $data['title'],
			'item_type' => $item,
			'item_id'   => $itemId,
			]);

		$translations     = Translations::where('key', $data['key'])->
		                                  where('language_content_id', $languageContents->id)->
		                                  first();

		if ($translations)
		{
			$translations->key         = $data['key'];
			$translations->value       = $data['value'];
			$translations->language_id = $data['language_id'];
		}
		else
		{
			$translations =  new Translations([
				'key'         => $data['key'],
				'value'       => $data['value'], 
				'language_id' => $data['language_id']
				]);
		}
		$languageContents->translations()->save($translations);
	}

	/**
	 * Delete the translations form specific item and
	 * item id.
	 * 
	 * @param  string  $item   The name of the item the 
	 *                         language content belongs to. 
	 *                         ex: 'user', 'content' ....
	 * @param  integer $itemId The id of the item the 
	 *                         language content belongs to. 
	 *                         ex: 'user', 'content' ....
	 * @return void
	 */
	public function deleteItemLanguageContents($item, $itemId)
	{	
		foreach ($this->getItemLanguageContent($item, $itemId) as  $languageContent) 
		{
			$languageContent->translations()->delete();
			$languageContent->delete();
		}
	}

	/**
	 * Return the translations with language
	 * match the given language id for a 
	 * language content object.
	 * 
	 * @param  object  $languageContent
	 * @param  integer $languageId
	 * @return object
	 */
	public function getLanguageContentTranslations($languageContent, $languageId)
	{
		if ( ! $languageContent) return false;
		return $languageContent->translations->where('language_id', $languageId)->first() ?: false;
	}

	/**
	 * Return a collection of language content containig
	 * an attribute telling if that language content 
	 * translated to all languages or not.
	 * 
	 * @param  string  $item   The name of the item the 
	 *                         language content belongs to. 
	 *                         ex: 'user', 'content' ....
	 * @param  integer $itemId The id of the item the 
	 *                         language content belongs to. 
	 *                         ex: 'user', 'content' ....
	 * @return collection
	 */
	public function languageContentsNeedTranslation($item, $itemId)
	{	
		$languageContents = $this->getItemLanguageContent($item, $itemId);

		foreach ($languageContents as $languageContent) 
		{
			$languages = array();
			foreach (\CMS::languages()->all() as $lang) 
			{
				if( ! in_array($lang->id, $languageContent->translations->lists('language_id')))
				{
					$languages[] = ['lang' => $lang, 'translated' => false];
					continue;
				}
				$languages[] = ['lang' => $lang, 'translated' => true];
			}
			$languageContent->languages = $languages;
		}
		return $languageContents;
	}
}
