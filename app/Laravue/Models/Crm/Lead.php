<?php

namespace App\Laravue\Models\Crm;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Query\Builder;

class Lead extends Model
{
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'neighborhood', 'city', 'state', 'zipcode', 'homephome', 'mobile', 'email', 'registration_id', 'tax_id'
    ];
	
}
