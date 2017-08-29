<?php namespace App\Http\Requests\Backend\WorkshopGroupTutor;

use App\Http\Requests\Request;

class UpdateWorkshopGroupTutorRequest extends Request {

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
            'max_students'					=>  'required',
            'position'					=>  'required',
        ];
    }
}