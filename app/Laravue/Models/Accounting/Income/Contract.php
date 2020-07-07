<?php

namespace App\Laravue\Models\Accounting\Income;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'account_id',
        'paid_at',
        'amount',
        'currency_code',
        'currency_rate',
        'lead_id',
        'description',
        'category_id',
        'payment_method',
        'reference',
        'attachment',
    ];
}
