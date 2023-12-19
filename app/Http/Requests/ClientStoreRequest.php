<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientStoreRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'client_name' => 'required|min:3|max:255',
            'client_street' => 'required|min:3|max:255',
            'client_city' => 'required|min:3|max:255',
            'client_email' => 'required|min:3|max:255|email',
            'client_nip' => 'required|NIP',
            'client_house_number' => 'required',
            'client_postcode' => 'required',
            'client_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',
        ];
    }

    public function messages() {
        return [
            
        ];
    }
}
