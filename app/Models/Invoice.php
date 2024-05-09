<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'invoice_num',
        'is_paid',
        'sale_date',
        'payment_deadline',
        'seller_name',
        'seller_street',
        'seller_city',
        'seller_email',
        'seller_nip',
        'seller_house_number',
        'seller_postcode',
        'seller_phone',
        'buyer_name',
        'buyer_street',
        'buyer_city',
        'buyer_email',
        'buyer_nip',
        'buyer_house_number',
        'buyer_postcode',
        'buyer_phone',
        'discount_total',
        'vat_total',
        'value_netto',
        'note'
    ];

    public function getProducts()
    {
        return InvoicesProduct::where('invoice_id', $this->id)->get();
    }
}
