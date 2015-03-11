<?php namespace App\Modules\Language\Traits;

use App\Modules\Language\LanguageContent;
use App\Modules\Language\LanguageContentData;
use App\Modules\Language\Repositories\LanguageRepository;

trait LanguageContentTrait{
	
	public function getContent($obj,$languageKey, $title = false)
	{
		if( ! $title)
		{
			$data = array();
			foreach ($obj->LanguageContents as $languageContent) 
			{
				$languageContentData =  $languageContent->languageContentData()->
				where('language_id', $this->getLanguageByKey($languageKey)->id)->first();
				
				$data[$languageContentData->key] = $languageContentData->value;
			}
			return $data;
		}
		else
		{
			$languageContent = $obj->LanguageContents()->where('title', $title)->first();
			
			return $languageContent->languageContentData()->
			where('language_id', $this->getLanguageByKey($languageKey)->id)->first()->value;
		}
	}

	public function getLanguageContent($id)
	{
		return LanguageContent::find($id);
	}

	public function getItemLanguageContent($item, $itemId)
	{
		return LanguageContent::whereRaw('item_id=? and item_type=?', [$itemId, $item])->get();
	}

	public function createLanguageContent($data, $item, $itemId)
	{
		$languageContents = array();
		for ($i = 0 ; $i < count($data['key']) ; $i++) 
		{ 
			$languageContents[]  = LanguageContent::firstOrCreate([
				'title'     => $data['title'][$i],
				'item_type' =>  ucfirst($item),
				'item_id'   => $itemId,
				]);

			$languageContentData = LanguageContentData::where('key', $data['key'][$i])
			->where('language_content_id', $languageContents[$i]->id)->first();

			if ($languageContentData)
			{
				$languageContentData->key         = $data['key'][$i];
				$languageContentData->value       = $data['value'][$i];
				$languageContentData->language_id = $data['language_id'];
			}
			else
			{
				$languageContentData =  LanguageContentData::create([
					'key'         => $data['key'][$i],
					'value'       => $data['value'][$i], 
					'language_id' => $data['language_id']
					]);
			}
			$languageContents[$i]->languageContentData()->save($languageContentData);
		}
		return $languageContents;
	}

	public function deleteLanguageContent($id)
	{	
		$languageContent = $this->getLanguageContent($id);
		$languageContent->delete();
	}

	public function getLanguageContentData($languageContent, $languageId)
	{
		if ( ! $languageContent) return false;

		return $languageContent->languageContentData->where('language_id', $languageId)->first() ?: false;
	}

	public function languageContentsNeedTranslation($item, $itemId)
	{	
		$needTranslation  = array();
		$languageContents = $this->getItemLanguageContent($item, $itemId);
		foreach ($languageContents as $languageContent) 
		{
			$languages = array();
			foreach ($this->getAllLanguages() as $lang) 
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