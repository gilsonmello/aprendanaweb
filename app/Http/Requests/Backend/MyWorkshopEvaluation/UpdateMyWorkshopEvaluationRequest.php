<?php namespace App\Http\Requests\Backend\MyWorkshopEvaluation;

use App\Http\Requests\Request;

class UpdateMyWorkshopEvaluationRequest extends Request {

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
        ];
    }
}