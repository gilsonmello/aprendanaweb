<?php namespace App\Http\Requests\Backend\Course;

use App\Http\Requests\Request;

class UpdateCourseRequest extends Request {

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
            'title'					=>  'required',
            'slug'					=>  'required|regex:([A-Za-z0-9\-\/\(\)\.]+)|unique:courses,slug,'.$this->courses,
            'description'			=>  'required',
            'activation_date'		=>  'required',
            'video_ad_url'    		=>  'url',
        ];
    }
}