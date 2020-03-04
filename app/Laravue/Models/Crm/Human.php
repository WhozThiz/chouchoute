<?php

namespace App\Laravue\Models\Crm;

use Illuminate\Database\Eloquent\Model;
//use Illuminate\Database\Query\Builder;

class Human extends Model
{
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'address', 'neighborhood', 'city', 'state', 'zipcode', 'homephome', 'mobile', 'registration', 'ssn', 'email'
    ];
	
}
