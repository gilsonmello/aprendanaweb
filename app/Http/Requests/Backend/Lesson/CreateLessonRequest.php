<?php namespace App\Http\Requests\Backend\Lesson;

use App\Http\Requests\Request;

class CreateLessonRequest extends Request {

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
            'description'			=>  'required',
            'activation_date'		=>  'required',
            'video_ad_url'     		=>  'url',
            'sequence'              => 'unique_with:module,id'

        ];
    }
}