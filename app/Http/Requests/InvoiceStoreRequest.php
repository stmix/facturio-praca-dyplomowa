<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class InvoiceStoreRequest extends FormRequest
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
            'paid_from' => 'required',
            'paid_to' => 'required',

            'seller_name' => 'required|min:3|max:255',
            'seller_street' => 'required|min:3|max:255',
            'seller_city' => 'required|min:3|max:255',
            'seller_email' => 'required|min:3|max:255|email',
            'seller_nip' => 'required|NIP',
            'seller_house_number' => 'required',
            'seller_postcode' => 'required',
            'seller_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',

            'buyer_name' => 'required|min:3|max:255',
            'buyer_street' => 'required|min:3|max:255',
            'buyer_city' => 'required|min:3|max:255',
            'buyer_email' => 'required|min:3|max:255|email',
            'buyer_nip' => 'required|NIP',
            'buyer_house_number' => 'required|numeric',
            'buyer_postcode' => 'required|post_code',
            'buyer_phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:9',

            'product_name1' => '',
            'product_count1' => '',
            'product_price1' => '',
            'product_discount1' => '',
            'product_fullprice1' => '',

            'product_fullprice_sum' => 'required',
        ];
    }
    public function messages() {
        return [
            
        ];
    }
}
