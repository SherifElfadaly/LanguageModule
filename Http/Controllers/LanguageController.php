<?php namespace App\Modules\Language\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Language\Http\Requests\LanguageFormRequest;


class LanguageController extends BaseController {

	/**
	 * Create new ModuleController instance.
	 */
	public function __construct()
	{
		parent::__construct('Languages');
	}

	/**
	 * Display a listing of the languages.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
		$this->hasPermission('show');
		$languages = \CMS::languages()->all();
		
		return view('language::languages.languages', compact('languages'));
	}

	/**
	 * Show the form for creating a new language.
	 *
	 * @return Response
	 */
	public function getCreate()
	{
		$this->hasPermission('add');
		return view('language::languages.addlanguage');
	}

	/**
	 * Store a newly created language in storage.
	 *
	 * @return Response
	 */
	public function postCreate(LanguageFormRequest $request)
	{
		$this->hasPermission('add');
		$data['key']         = $request->get('key');
		$data['title']       = $request->get('title');
		$data['description'] = $request->get('description');
		$data['flag']        = $request->get('flag');
		$data['is_active']   = $request->get('is_active')  ? 1 : 0;
		$data['is_default']  = $request->get('is_default') ? 1 : 0;

		$language = \CMS::language()->createLanguage($data);

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
		$this->hasPermission('edit');
		$language = \CMS::language()->find($id);
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
		$this->hasPermission('edit');
		$language            = \CMS::language()->find($id);
		$data['key']         = $request->get('key');
		$data['title']       = $request->get('title');
		$data['description'] = $request->get('description');
		$data['flag']        = $request->get('flag');
		$data['is_active']   = $request->get('is_active') ? 1 : 0;
		$data['is_default']  = $request->get('is_default') ? 1 : 0;

		\CMS::language()->updatetLanguage($language->id, $data);
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
		$this->hasPermission('delete');
		\CMS::language()->delete($id);
		return 	redirect()->back();
	}

	/**
	 * Activate or disaple a given language.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getActive($id)
	{
		$this->hasPermission('edit');
		\CMS::language()->changeActive($id);

		return 	redirect()->back();
	}

	/**
	 * Set the given language to default.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getDefault($id)
	{
		$this->hasPermission('edit');
		\CMS::language()->changeDefault($id);
		
		return 	redirect()->back();
	}
}
