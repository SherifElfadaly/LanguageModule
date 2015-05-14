<?php namespace App\Modules\Language\Http\Controllers;

use App\Http\Controllers\BaseController;
use Illuminate\Http\Request;

class LanguageContentController extends BaseController {

	/**
	 * Create new ModuleController instance.
	 */
	public function __construct()
	{
		parent::__construct('LanguageContents');
	}

	/**
	 * Display the languageContent.
	 *
	 * @return Response
	 */
	public function getShow($item, $itemId)
	{
		$this->hasPermission('show');
		$languageContents =  \CMS::languageContents()->languageContentsNeedTranslation($item, $itemId);

		return view('language::languagecontents.languagecontents', compact('languageContents', 'item', 'itemId'));
	}

	/**
	 * Show the form for creating a new languageContent.
	 *
	 * @return Response
	 */
	public function getCreate($item, $itemId, Request $request, $languageId = false, $languageContentId = false)
	{	
		$this->hasPermission('add');
		if($request && $request->ajax()) 
		{
			$insertedGalleries = \CMS::galleries()->getGalleries($request->input('ids'));
			return $insertedGalleries;
		}

		$mediaLibrary        = \CMS::galleries()->getMediaLibrary();
		$language            = $languageId ? \CMS::language()->find($languageId) : \CMS::language()->getDefaultLanguage();
		$languageContent     = $languageContentId ? \CMS::languageContents()->find($languageContentId) : false;
		$languageContentData = \CMS::languageContents()->getLanguageContentData($languageContent, $languageId);

		return view('language::languagecontents.addlanguagecontent', compact('language', 'languageContent', 'languageContentData', 'itemId', 'item', 'mediaLibrary'));
	}

	/**
	 * Store a newly created languageContent in storage.
	 *
	 * @return Response
	 */
	public function postCreate(Request $request, $item, $itemId)
	{
		$this->hasPermission('add');
		$errors = array();
		foreach ($request->input('title') as $key) 
		{
			if (strlen(trim($key)) == 0) 
			{
				$errors[] = "Title Required";
				break;
			}
		}

		foreach ($request->input('key') as $key) 
		{
			if (strlen(trim($key)) == 0) 
			{
				$errors[] = "Key Required";
				break;
			}
		}

		foreach ($request->input('value') as $value) 
		{
			if (strlen(trim($value)) == 0) 
			{
				$errors[] = "Value Required";
				break;
			}
		}
		if ( ! empty($errors)) 	return redirect()->back()->withErrors($errors);

		\CMS::languageContents()->createLanguageContent($request->all(), $item, $itemId);
		
		return 	redirect()->back()->with('message', 'Your Language Content had been created');
	}

	/**
	 * Remove the specified languageContent from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->hasPermission('delete');
		\CMS::languageContents()->delete($id);
		return 	redirect()->back();
	}
}
