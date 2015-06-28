<?php namespace App\Modules\Language\Http\Controllers;

use App\Modules\Core\Http\Controllers\BaseController;
use Illuminate\Http\Request;
use App\Modules\Language\Http\Requests\LanguageContentFormRequest;

class LanguageContentController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getShow'                     => 'show',
	'getLanguagecontentgalleries' => 'edit',
	];

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
	 * @param  string  $item              The name of the item the 
	 *                                    language content belongs to. 
	 *                                    ex: 'user', 'content' ....
	 * @param  integer $itemId            The id of the item the 
	 *                                    language content belongs to. 
	 *                                    ex: 'user', 'content' ....
	 * @return Response
	 */
	
	public function getShow($item, $itemId)
	{
		$languageContents =  \CMS::languageContents()->languageContentsNeedTranslation($item, $itemId);
		return view('language::languagecontents.languagecontents', compact('languageContents', 'item', 'itemId'));
	}

	/**
	 * Show the form for creating a new languageContent.
	 * 
	 * @param  string  $item              The name of the item the 
	 *                                    language content belongs to. 
	 *                                    ex: 'user', 'content' ....
	 * @param  integer $itemId            The id of the item the 
	 *                                    language content belongs to. 
	 *                                    ex: 'user', 'content' ....
	 * @param  integer $languageId
	 * @param  integer $languageContentId
	 * @return Response
	 */
	public function getCreate($item, $itemId, $languageId = false, $languageContentId = false)
	{	
		$mediaLibrary    = \CMS::galleries()->getMediaLibrary();
		$language        = $languageId ? \CMS::language()->find($languageId) : \CMS::language()->getDefaultLanguage();
		$languageContent = $languageContentId ? \CMS::languageContents()->find($languageContentId) : false;
		$translations    = \CMS::languageContents()->getLanguageContentTranslations($languageContent, $languageId);

		return view('language::languagecontents.addlanguagecontent', compact('language', 'languageContent', 'translations', 'itemId', 'item', 'mediaLibrary'));
	}

	/**
	 * Store a newly created languageContent in storage.
	 * 
	 * @param  LanguageContentFormRequest $request
	 * @param  string  $item              The name of the item the 
	 *                                    language content belongs to. 
	 *                                    ex: 'user', 'content' ....
	 * @param  integer $itemId            The id of the item the 
	 *                                    language content belongs to. 
	 *                                    ex: 'user', 'content' ....
	 * @return response
	 */
	public function postCreate(LanguageContentFormRequest $request, $item, $itemId)
	{
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
		\CMS::languageContents()->delete($id);
		return 	redirect()->back();
	}

	/**
	 * Return a gallery array from the given ids,
	 * handle the ajax request for inserting galleries
	 * to the language content.
	 * 
	 * @param  Request $request
	 * @return Response
	 */
	public function getLanguagecontentgalleries(Request $request)
	{	
		$insertedGalleries = \CMS::galleries()->getGalleries($request->input('ids'));
		return $insertedGalleries;
	}
}
