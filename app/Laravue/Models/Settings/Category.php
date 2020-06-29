<?php

namespace App\Laravue\Models\Settings;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $fillable = [
        'parent_id',
        'name',
        'description',
    ];

    public function parent() {
        return $this->belongsTo('App\Laravue\Models\Settings\Category', 'parent_id');
    }

    public function children() {
        return $this->hasMany('App\Laravue\Models\Settings\Category', 'parent_id')->with('children');
    }

    public function currency() {
        return $this->hasMany('App\Laravue\Models\Settings\Category', 'currency');
    }

    public function medications() {
        return $this->hasMany('App\Laravue\Models\Crm\Medication', 'medication');
    }

    public function vaccines() {
        return $this->hasMany('App\Laravue\Models\Crm\Vaccine', 'vaccine');
    }

}
