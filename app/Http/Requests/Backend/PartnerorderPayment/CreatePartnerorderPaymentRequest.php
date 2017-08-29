<?php namespace App\Http\Requests\Backend\PartnerorderPayment;

use App\Http\Requests\Request;

class CreatePartnerorderPaymentRequest extends Request {

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
            'due_date'					=>  'required',
            'value'					=>  'required',
        ];
    }
}