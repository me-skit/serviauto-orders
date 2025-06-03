<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'name' => 'Nombre',
            'phone_number' => 'Teléfono',
            'location_id' => 'Taller'
        ];
    }

    public function messages()
    {
        return [
            'phone_number.regex' => 'El campo :attribute debe contener exactamente 8 dígitos.',
        ];
    }

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
            'phone_number' => ['nullable', 'regex:/^\d{8}$/'],
            'location_id' => ['required', 'exists:locations,id']
        ];
    }
}
