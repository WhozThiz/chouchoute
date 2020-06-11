<?php

namespace App\Laravue\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'breed',
        'coat',
        'birthday',
        'gender',
        'neutered',
        'registration',
    ];

    public function vaccines() {
        return $this->hasMany('App\Laravue\Models\Crm\Vaccine');
    }
}
