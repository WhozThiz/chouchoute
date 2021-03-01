<?php

namespace App\Laravue\Models\Crm;

use Illuminate\Database\Eloquent\Model;

class Lead extends Model
{
    
	/**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 
        'address', 
        'neighborhood', 
        'city', 
        'state', 
        'zipcode', 
        'homephone', 
        'mobile', 
        'email', 
        'registration_id', 
        'tax_id',
    ];

    public function pets()
    {
        return $this->hasMany(Pet::class, 'lead_id');
    }
	
}
