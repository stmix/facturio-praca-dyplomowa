<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SettingsStoreRequest extends FormRequest
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
            'name' => 'required|min:2|max:255',
            'street' => 'required|min:2|max:255',
            'city' => 'required|min:2|max:255',
            'email' => 'required|min:2|max:255|email',
            'nip' => 'required|NIP',
            'house_number' => 'required',
            'postcode' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages() {
        return [
            
        ];
    }
}
