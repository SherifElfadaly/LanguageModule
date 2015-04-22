<?php namespace App\Modules\Language\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Language\Repositories\LanguageRepository;
use GalleryRepository;

use Illuminate\Http\Request;
class LanguageContentController extends Controller {

	/**
	 * The InstallationRepository implementation.
	 *
	 * @var InstallationRepository
	 */
	protected $language;

	/**
	 * Create new ModuleController instance.
	 * @param InstallationRepository
	 */
	public function __construct(LanguageRepository $language)
	{
		$this->language = $language;
		$this->middleware('AclAuthenticate');
	}

	/**
	 * Display the languageContent.
	 *
	 * @return Response
	 */
	public function getShow($item, $itemId)
	{
		$item             = ucfirst($item);
		$languageContents =  $this->language->languageContentsNeedTranslation($item, $itemId);

		return view('language::languagecontents.languagecontents', compact('languageContents', 'item', 'itemId'));
	}

	/**
	 * Show the form for creating a new languageContent.
	 *
	 * @return Response
	 */
	public function getCreate($item, $itemId, Request $request, $languageId = false, $languageContentId = false)
	{	
		if($request && $request->ajax()) 
		{
			$insertedGalleries = GalleryRepository::getGalleries($request->input('ids'));
			return $insertedGalleries;
		}

		$mediaLibrary        = GalleryRepository::getMediaLibrary();
		$language            = $languageId ? $this->language->getLanguage($languageId) : $this->language->getDefaultLanguage();
		$languageContent     = $languageContentId ? $this->language->getLanguageContent($languageContentId) : false;
		$languageContentData = $this->language->getLanguageContentData($languageContent, $languageId);

		return view('language::languagecontents.addlanguagecontent', compact('language', 'languageContent', 'languageContentData', 'itemId', 'item', 'mediaLibrary'));
	}

	/**
	 * Store a newly created languageContent in storage.
	 *
	 * @return Response
	 */
	public function postCreate(Request $request, $item, $itemId)
	{
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

		$this->language->createLanguageContent($request->all(), $item, $itemId);
		
		return 	redirect()->back()->with('message', 'Your languageContent had been created');
	}

	/**
	 * Remove the specified languageContent from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->language->deleteLanguageContent($id);
		return 	redirect()->back();
	}

	/**
	 * Duplicate the languageContent for all languages
	 * with the default language.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDuplicate($id)
	{
		$this->language->duplicateLanguageContentData($this->language->getLanguageContent($id));
		return 	redirect()->back();
	}

}
