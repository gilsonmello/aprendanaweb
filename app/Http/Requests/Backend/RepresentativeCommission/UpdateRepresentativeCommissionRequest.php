<?php namespace App\Http\Requests\Backend\RepresentativeCommission;

use App\Http\Requests\Request;

class UpdateRepresentativeCommissionRequest extends Request {

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
            'range_begin'					=>  'required',
            'range_end'	=>  'required',
            'date_begin'	=>  'required',
            'commission_percentage'	=>  'required',
        ];
    }
}