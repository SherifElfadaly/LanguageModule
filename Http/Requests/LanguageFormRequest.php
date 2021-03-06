<?php namespace App\Modules\Language\Http\Requests;

use App\Http\Requests\Request;

class LanguageFormRequest extends Request {

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
			'key'         => 'required|max:3|unique:languages,id,'.$this->get('id'),
			'title'       => 'required|max:150',
			'description' => 'required|max:255',
			'flag'        => 'required|max:100',
		];
	}

}
