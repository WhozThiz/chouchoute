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

    public function category()
    {
        return $this->belongsTo('App\Laravue\Models\Settings\Category');
    }

    public function lead()
    {
        return $this->belongsTo('App\Laravue\Models\Crm\Lead');
    }

    public function account()
    {
        return $this->belongsTo('App\Laravue\Models\Accounting\Banking\Account');
    }
}
