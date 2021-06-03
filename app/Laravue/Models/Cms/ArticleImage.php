<?php

namespace App\Laravue\Models\Cms;

use Illuminate\Database\Eloquent\Model;

class ArticleImage extends Model
{
    protected $fillable = [
        'article_id',
        'article_image_path',
        'article_image_caption',
        'article_image_source',
    ];

    public function article()
    {
        return $this->belongsTo('Laravue\Models\Cms\Article', 'article_id');
    }
}
