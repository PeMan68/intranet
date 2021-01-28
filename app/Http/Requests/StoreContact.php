<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContact extends FormRequest
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
            'name' => 'required',
            'company' => 'nullable',
            'telephone' => 'nullable',
            'address1' => 'nullable',
            'address2' => 'nullable',
            'zip_city' => 'nullable',
            'customer_number' => 'nullable',
            'email' => 'nullable|email',
            'internal' => 'nullable',

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
            'name.required' => 'Namn är obligatoriskt',
            'email.required' => 'E-postadressen är ogiltig',
        ];
    }
}
