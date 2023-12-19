<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'street',
        'city',
        'email',
        'nip',
        'house_number',
        'postcode',
        'phone',
    ];
}
