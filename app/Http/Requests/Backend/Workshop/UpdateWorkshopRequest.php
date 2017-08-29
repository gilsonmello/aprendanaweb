<?php namespace App\Http\Requests\Backend\Workshop;

use App\Http\Requests\Request;

class UpdateWorkshopRequest extends Request {

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
            'description'	    =>	'required',
        ];
    }
}