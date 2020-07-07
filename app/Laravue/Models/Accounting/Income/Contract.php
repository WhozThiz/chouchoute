<?php

namespace App\Laravue\Models\Accounting\Income;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'account_id',
        'category_id',
        'lead_id',
        'paid_at',
        'amount',
        'currency_code',
        'currency_rate',
        'description',
        'payment_method',
        'reference',
        'attachment',
    ];
}
