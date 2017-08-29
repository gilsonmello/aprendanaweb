<?php namespace App\Http\Requests\Backend\WorkshopTutor;

use App\Http\Requests\Request;

class CreateWorkshopTutorRequest extends Request {

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
            'tutors'					=>  'required',
            'criterias'					=>  'required',
            'max_students'					=>  'required',
            'position'					=>  'required',
        ];
    }
}