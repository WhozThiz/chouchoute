<?php

namespace App\Laravue\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Vaccine extends Model
{
    protected $fillable = [
        'pet_id',
        'vaccinedate',
        'vaccine',
        'vaccinebatch',
    ];

    public function category() {
        return $this->belongsTo('App\Laravue\Models\Settings\Category', 'vaccine');
    }

}
