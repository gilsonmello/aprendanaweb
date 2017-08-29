<?php namespace App\Http\Requests\Backend\Preenrollment;

use App\Http\Requests\Request;

class CreatePreenrollmentRequest extends Request {

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
            'course_id'					=>  'required',
            'partner_id'					=>  'required',
            'total_enrollments'					=>  'required',
            'date'					=>  'required',
        ];
    }
}