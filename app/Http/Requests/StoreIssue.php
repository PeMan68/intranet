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
            'task' => 'required',
			'description' => 'required',
			'person' => 'required',
			'phone' => 'required',
			'email' => 'required',
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
			'task.required' => 'Välj område',
			'description.required' => 'Formell beskrivning är obligatorisk',
			'person.required' => 'Kontaktperson är obligatorisk',
			'phone.required' => 'Telefonnummer är obligatoriskt',
			'email.required' => 'E-postadress är obligatorisk',
		];
	}
}
