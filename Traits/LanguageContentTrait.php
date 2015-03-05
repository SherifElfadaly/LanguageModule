<?php namespace App\Modules\Language\Traits;

use App\Modules\Language\LanguageContent;
use App\Modules\Language\LanguageContentData;
use App\Modules\Language\Repositories\LanguageRepository;

trait LanguageContentTrait{
	
	public function getLanguageContent($id)
	{
		return LanguageContent::find($id);
	}

	public function getItemLanguageContent($item, $itemId)
	{
		return LanguageContent::whereRaw('item_id=? and item_type=?', [$itemId, $item])->get();
	}

	public function prepareLanguageContentData($data)
	{
		$languageContents = array();
		for ($i = 0 ; $i < count($data['key']) ; $i++) 
		{ 
			$languageContentData = LanguageContentData::where('key', $data['key'][$i])->first();

			if ($languageContentData)
			{
				$languageContentData->key         = $data['key'][$i];
				$languageContentData->value       = $data['value'][$i];
				$languageContentData->language_id = $data['language_id'];
			}
			else
			{
				$languageContentData =  LanguageContentData::firstOrNew([
					'key'         => $data['key'][$i],
					'value'       => $data['value'][$i], 
					'language_id' => $data['language_id']
					]);
			}

			$languageContents[]  =  LanguageContent::firstOrNew(['title' => $data['title'][$i]]);

			$languageContents[$i]->save();
			$languageContents[$i]->languageContentData()->save($languageContentData);
		}
		return $languageContents;
	}

	public function createLanguageContent($languageContents, $item, $itemId)
	{	
		foreach ($languageContents as $languageContent) 
		{
			$languageContent->item_id   = $itemId;
			$languageContent->item_type = ucfirst($item);
			$languageContent->save();
		}
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