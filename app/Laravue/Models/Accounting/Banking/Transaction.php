<?php

namespace App\Laravue\Models\Accounting\Banking;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'account_id',
        'type',
        'category_id',
        'lead_id',
        'paid_at',
        'amount',
        'currency_code',
        'currency_rate',
        'description',
        'payment_method',
        'reference',
        'parent_id',
    ];
}
