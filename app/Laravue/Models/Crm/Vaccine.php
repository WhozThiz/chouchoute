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
}
