<?php namespace App\Http\Requests\Backend\Video;

use App\Http\Requests\Request;

class CreateVideoRequest extends Request {

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
            'slug'                  =>  'required|unique:videos',
            'url'                   =>  'required|url',
            'content'               =>  'required',
            'activation_date'		=>  'required',
        ];
    }
}