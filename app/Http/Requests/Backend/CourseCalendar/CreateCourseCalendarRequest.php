<?php namespace App\Http\Requests\Backend\CourseCalendar;

use App\Http\Requests\Request;

class CreateCourseCalendarRequest extends Request {

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
            'date'			=>  'required',
            'description'	=>  'required',
        ];
    }
}