<?php

namespace App\Laravue\Models\Accounting\Banking;

use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $fillable = [
        'name',
        'number',
        'currency',
        'opening_balance',
        'bank_name',
        'bank_phone',
        'bank_address',
        'enabled',
    ];
}
