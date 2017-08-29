<?php namespace App\Http\Requests\Backend\Module;

use App\Http\Requests\Request;

class UpdateModuleRequest extends Request {

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
            'name'					=>  'required',
            'description'			=>  'required',
            'activation_date'		=>  'required',
            'video_ad_url'     		=>  'url',
        ];
    }
}