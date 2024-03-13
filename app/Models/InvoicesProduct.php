<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoicesProduct extends Model
{
    use HasFactory;

    public $fillable = [
        'invoice_id',
        'product_name',
        'number',
        'price',
        'vat',
        'discount'
    ];
}
