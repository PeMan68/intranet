<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIssue extends FormRequest
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
            'taskPersonal_id' => 'required',
            'task_id' => 'required',
			'customerName' => 'required',
			'customerTel' => 'required_with:customerName',
			'header' => 'required',
			'description' => 'required',
			'customer' => 'nullable',
			'customerNumber' => 'nullable',
			'customerMail' => 'nullable|email',
			'descriptionInternal' => 'nullable',
			'urgent' => 'nullable',
			'vip' => 'nullable',
			'prio' => 'nullable',
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
			'task_id.required' => 'Välj område',
			'header.required' => 'Rubrik är obligatorisk',
			'description.required' => 'Formell beskrivning är obligatorisk',
			'customerName.required' => 'Kontaktperson är obligatorisk',
			'customerTel.required_with' => 'Ange telefonnummer till  kontaktpersonen',
			'taskPersonal_id.required' => 'Fyll i om ärendet är personligt eller ej',
			'customerMail.email' => 'Email-adressen är ogiltig',
		];
	}
}
