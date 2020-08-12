<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDocument extends FormRequest
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
            'description' => 'required|max:191',
			'document' => 'required|max:2048',
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
			'description.required' => 'Ange en kort beskrivning vad det är för fil',
			'description.max' => 'Beskrivning får vara max 191 tecken',
			'document.required' => 'Filen saknas',
			'document.max' => 'Filen är större än 2MB',
		];
	}}
