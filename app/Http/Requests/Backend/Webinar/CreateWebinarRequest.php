<?php namespace App\Http\Requests\Backend\Webinar;

use App\Http\Requests\Request;

class CreateWebinarRequest extends Request {

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
            'title'	    =>	'required',
            'youtube_live_url'	    =>	'required',
            'description'					=>  'required',
            'courses_id'	    =>	'required',
        ];
    }
}