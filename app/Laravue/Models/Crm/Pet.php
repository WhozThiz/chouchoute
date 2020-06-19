<?php

namespace App\Laravue\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Pet extends Model
{
    protected $fillable = [
        'name',
        'breed',
        'coat',
        'birthdate',
        'gender',
        'color',
        'neutered',
        'registration',
        'lead_id',
    ];

    public function lead()
    {
        return $this->belongsTo(Lead::class, 'lead_id');
    }
    
    public function vaccines() {
        return $this->hasMany('App\Laravue\Models\Crm\Vaccine');
    }
}
