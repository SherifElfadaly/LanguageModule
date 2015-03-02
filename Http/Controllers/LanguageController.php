<?php namespace App\Modules\Language\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Language\Repositories\LanguageRepository;
use App\Modules\Language\Http\Requests\LanguageFormRequest;


class LanguageController extends Controller {

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
	}

	/**
	 * Display a listing of the languages.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$languages = $this->language->getAllLanguages();
		return view('language::languages.languages', compact('languages'));
	}

	/**
	 * Show the form for creating a new language.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		return view('language::languages.addlanguage');
	}

	/**
	 * Store a newly created language in storage.
	 *
	 * @return Response
	 */
	public function postCreate(LanguageFormRequest $request)
	{
		$data['key']         = $request->get('key');
		$data['title']       = $request->get('title');
		$data['description'] = $request->get('description');
		$data['flag']        = $request->get('flag');
		$data['is_active']   = $request->get('is_active') ? 1 : 0;
		$data['is_default']  = $request->get('is_default') ? 1 : 0;

		$language = $this->language->createLanguage($data);

		return 	redirect()->back()->with('message', 'Your language had been created');
	}

	/**
	 * Show the form for editing the specified language.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getEdit($id)
	{
		$language = $this->language->getLanguage($id);
		return view('language::languages.editlanguage', compact('language'));
	}

	/**
	 * Update the specified language in storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function postEdit($id, LanguageFormRequest $request)
	{
		$language            = $this->language->getLanguage($id);
		$data['key']         = $request->get('key');
		$data['title']       = $request->get('title');
		$data['description'] = $request->get('description');
		$data['flag']        = $request->get('flag');
		$data['is_active']   = $request->get('is_active') ? 1 : 0;
		$data['is_default']  = $request->get('is_default') ? 1 : 0;

		$this->language->updatetLanguage($language->id, $data);
		return 	redirect()->back()->with('message', 'Your language had been Updated');
	}

	/**
	 * Remove the specified language from storage.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDelete($id)
	{
		$this->language->deleteLanguage($id);
		return 	redirect()->back();
	}

}
