<?php namespace App\Modules\Language\Repositories;

use App\AbstractRepositories\AbstractRepository;
use App\Modules\Language\LanguageContent;
use App\Modules\Language\LanguageContentData;

class LanguageContentRepository extends AbstractRepository
{
	protected function getModel()
	{
		return 'App\Modules\Language\LanguageContent';
	}

	protected function getRelations()
	{
		return ['languageContentData'];
	}

	public function search($query, $item)
	{	
		return LanguageContent::whereIn(
			'id', LanguageContentData::where('value', 'like', '%' . $query . '%')->lists('language_content_id'))->
			where('item_type', '=', $item)->lists('item_id');
	}

	public function getContent($itemId, $item, $languageKey, $title = false)
	{
		if( ! $title)
		{
			$data = array();
			foreach ($this->getItemLanguageContent($item, $itemId) as $languageContent) 
			{
				$languageContentData           =  $languageContent->
				                                  languageContentData()->
				                                  where('language_id', \CMS::languages()->getLanguageByKey($languageKey)->id)->
				                                  first();
				                                  
				if($languageContentData === null)
				{
					$languageContentData       =  $languageContent->
					                              languageContentData()->
					                              where('language_id', \CMS::languages()->getDefaultLanguage()->id)->
					                              first();
				}
				$data[$languageContent->title] = $languageContentData->value;
			}
			return $data;
		}
		else
		{
			$languageContent         = $this->getItemLanguageContent($item, $itemId)->
			                           where('title', $title)->
			                           first();
			
			$languageContentData     = $languageContent->
			                           languageContentData()->
			                           where('language_id', \CMS::language()->getLanguageByKey($languageKey)->id)->
			                           first();

           if($languageContentData === null)
           {
	           	$languageContentData = $languageContent->
	           	                       languageContentData()->
	           	                       where('language_id', \CMS::language()->getDefaultLanguage()->id)->
	           	                       first();
           }
           return $languageContentData->value;
		}
	}

	public function getItemLanguageContent($item, $itemId)
	{
		return LanguageContent::with($this->getRelations())->
		                        whereRaw('item_id=? and item_type=?', [$itemId, $item])->
		                        get();
	}

	public function createLanguageContent($data, $item, $itemId)
	{
		$languageContents = array();
		for ($i = 0 ; $i < count($data['key']) ; $i++) 
		{ 
			$languageContents[]  = LanguageContent::firstOrCreate([
				'title'     => $data['title'][$i],
				'item_type' => $item,
				'item_id'   => $itemId,
				]);

			$languageContentData = LanguageContentData::where('key', $data['key'][$i])->
			                       where('language_content_id', $languageContents[$i]->id)->
			                       first();

			if ($languageContentData)
			{
				$languageContentData->key         = $data['key'][$i];
				$languageContentData->value       = $data['value'][$i];
				$languageContentData->language_id = $data['language_id'];
			}
			else
			{
				$languageContentData =  new LanguageContentData([
					'key'         => $data['key'][$i],
					'value'       => $data['value'][$i], 
					'language_id' => $data['language_id']
					]);
			}
			$languageContents[$i]->languageContentData()->save($languageContentData);
		}
		return $languageContents;
	}

	public function deleteItemLanguageContents($item, $itemId)
	{	
		foreach ($this->getItemLanguageContent($item, $itemId) as  $languageContent) 
		{
			$languageContent->languageContentData()->delete();
			$languageContent->delete();
		}
	}

	public function getLanguageContentData($languageContent, $languageId)
	{
		if ( ! $languageContent) return false;
		return $languageContent->languageContentData->where('language_id', $languageId)->first() ?: false;
	}

	public function languageContentsNeedTranslation($item, $itemId)
	{	
		$languageContents = $this->getItemLanguageContent($item, $itemId);

		foreach ($languageContents as $languageContent) 
		{
			$languages = array();
			foreach (\CMS::languages()->all() as $lang) 
			{
				if( ! in_array($lang->id, $languageContent->languageContentData->lists('language_id')))
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
