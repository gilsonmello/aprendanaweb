<?php namespace App\Http\Requests\Backend\Course;

use App\Http\Requests\Request;

class CreateCourseRequest extends Request {

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
            'slug'					=>  'required|unique:courses|regex:([A-Za-z0-9\-\/\(\)\.]+)',
            'description'			=>  'required',
            'activation_date'		=>  'required',
            'video_ad_url'    		=>  'url',
        ];
    }
}