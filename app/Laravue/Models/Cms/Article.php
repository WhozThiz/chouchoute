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
        return $this->belongsTo('App\Laravue\Models\User');
    }

    public function article_images()
    {
        return $this->hasMany('App\Laravue\Models\Cms\ArticleImage');
    }
}
