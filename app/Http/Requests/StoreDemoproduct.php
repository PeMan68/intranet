<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDemoproduct extends FormRequest
{
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
       
       
            'product_id' => 'required',
            'location_id' => 'required',
            'status_id' => 'required',
            'comment' => 'nullable',
            'original_box' => 'nullable',
            'original_docs' => 'nullable',
            'tested' => 'nullable',
            'serial' => 'nullable',
            'invoice_date' => 'required',
            'invoice_no' => 'nullable',
            'version' => 'nullable',
            'used_by_user_id' => 'nullable',
            'used_by_customer_id' => 'nullable',
            'pcs' => 'required'
        ];
    }

    /**
	 * Get the error messages for the defined validation rules.
	 *
	 * @return array
	 */
	public function messages()
	{
		return [
			'invoice_date.required' => 'Ange ungefärlig ålder',
		];
	}
}
