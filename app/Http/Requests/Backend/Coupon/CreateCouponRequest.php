<?php namespace App\Http\Requests\Backend\Coupon;

use App\Http\Requests\Request;

class CreateCouponRequest extends Request {

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
            'code'	    =>  'required|unique:coupons,code,NULL,id,deleted_at,NULL',
            'start_date'	=>  'required',
            'due_date'	=>  'required',
            'limit'	=>  'required',
            'percentage'	=>  'required|discount:value',
            'value'	=>  'required',
            'description'	=>  'required'
        ];
    }
}