<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LocationRequest extends FormRequest
{
    public function attributes()
    {
        return [
            'location' => 'Lugar',
            'address' => 'Dirección',
            'phone' => 'Teléfono'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'El campo :attribute debe contener exactamente 8 dígitos.',
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
            'location' => 'required',
            'address' => 'required',
            'phone' => 'required|regex:/^\d{8}$/'
        ];
    }
}
