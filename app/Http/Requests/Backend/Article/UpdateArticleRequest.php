<?php namespace App\Http\Requests\Backend\Article;

use App\Http\Requests\Request;

class UpdateArticleRequest extends Request {

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
            'slug'					=>  'required|unique:articles,slug,'.$this->articles,
            'date'					=>  'required',
            'content'				=>  'required',
            'activation_date'		=>  'required',
            'video'         		=>  'url',
        ];
    }
}