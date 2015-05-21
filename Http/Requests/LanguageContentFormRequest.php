<?php namespace App\Modules\Language\Http\Requests;

use App\Http\Requests\Request;

class LanguageContentFormRequest extends Request {

	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'title' => 'required|max:150',
			'key'   => 'required|max:100',
			'value' => 'required',
		];
	}

}
