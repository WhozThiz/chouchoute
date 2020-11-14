<?php

namespace App\Laravue\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Medication extends Model
{
    protected $fillable = [
        'pet_id',
        'medication',
        'application',
        'validation',
        'batch',
    ];

    public function category() {
        return $this->belongsTo('App\Laravue\Models\Settings\Category', 'medication');
    }
}
