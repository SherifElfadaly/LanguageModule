<?php namespace App\Modules\Language\Http\Controllers;

use App\Http\Controllers\BaseController;
use App\Modules\Language\Http\Requests\LanguageFormRequest;


class LanguageController extends BaseController {

	/**
	 * Specify a list of extra permissions.
	 * 
	 * @var permissions
	 */
	protected $permissions = [
	'getActive'  => 'edit',
	'getDefault' => 'edit',
	];

	/**
	 * Create new LanguageController instance.
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
		return view('language::languages.addlanguage');
	}

	/**
	 * Store a newly created language in storage.
	 * 
	 * @param  LanguageFormRequest $request
	 * @return Response
	 */
	public function postCreate(LanguageFormRequest $request)
	{
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
		$language = \CMS::language()->find($id);
		return view('language::languages.editlanguage', compact('language'));
	}

	/**
	 * Update the specified language in storage.
	 *
	 * @param  int  $id
	 * @param  LanguageFormRequest $request
	 * @return Response
	 */
	public function postEdit($id, LanguageFormRequest $request)
	{
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
		\CMS::language()->delete($id);
		return 	redirect()->back();
	}

	/**
	 * Activate or deactivate a given language.
	 *
	 * @param  int  $id
	 * @return Response
	 */
	public function getActive($id)
	{
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
		\CMS::language()->changeDefault($id);
		return 	redirect()->back();
	}
}
