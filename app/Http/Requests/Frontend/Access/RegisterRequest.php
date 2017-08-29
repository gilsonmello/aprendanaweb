<?php namespace App\Http\Requests\Frontend\Access;

use App\Http\Requests\Request;

class RegisterRequest extends Request {

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
			'email' 	=> 'required|email|max:255|unique:users',
			'password'  => 'required|confirmed|min:6',
			'signing' => 'required',
			'name' => ['sometimes','required','regex:/^\P{C}+(?:\s\P{C}+)+$/'],
			'zip' => 'sometimes|required',
			'cel' => 'sometimes|required',
			'birthdate' => 'sometimes|required',
			'personal_id' => 'sometimes|required',
			'city' => 'sometimes|required'
		];
	}
}
