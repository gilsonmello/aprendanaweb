<?php namespace App\Http\Requests\Backend\Access\User;

use App\Http\Requests\Request;

class UpdateUserStudentRequest extends Request {

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
			'email'	=>	'required|email',
			'name'	=>  'required',
			'cel'	=>  'required',
			'birthdate'	=>  'required',
			'zip'	=>  'required',
			'personal_id'			=>  'required|cpf|min:9',
		];
	}
}