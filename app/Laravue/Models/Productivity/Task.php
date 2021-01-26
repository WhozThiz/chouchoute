<?php

namespace App\Laravue\Models\Productivity;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = ['title','completed'];
}
