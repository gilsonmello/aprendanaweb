<?php namespace App\Http\Requests\Backend\Workshop;

use App\Http\Requests\Request;

class CreateWorkshopRequest extends Request {

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
            'description'					=>  'required',
            'courses'	    =>	'required',

        ];
    }
}