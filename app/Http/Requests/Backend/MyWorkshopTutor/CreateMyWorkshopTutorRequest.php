<?php namespace App\Http\Requests\Backend\MyWorkshopTutor;

use App\Http\Requests\Request;

class CreateMyWorkshopTutorRequest extends Request {

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
            //'name'					=>  'required'
        ];
    }
}