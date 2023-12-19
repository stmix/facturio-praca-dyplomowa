<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductStoreRequest extends FormRequest
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
            'product_name' => 'required|min:2|max:255',
            'product_price' => 'required|numeric|min:3|max:255|',
            'producent' => 'required',
            'product_info' => 'sometimes',
        ];
    }

    public function messages() {
        return [
            
        ];
    }
}
