<?php

namespace App\Laravue\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class Article extends Model
{
    protected $fillable = [
        'user_id',
        'title',
        'authors',
        'keywords',
        'abstract',
        'introduction',
        'body',
        'references',
        'publish_time',
        'publish_status',
        'comment_status',
    ];

    public function user()
    {
        return $this->belongsTo('Laravue\Models\User');
    }

    public function post_images()
    {
        return $this->hasMany('Laravue\Models\Cms\ArticleImage');
    }
}
