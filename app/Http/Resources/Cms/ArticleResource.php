<?php

namespace App\Http\Resources\Cms;

use Illuminate\Http\Resources\Json\Resource;

class ArticleResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'display_time' => $this->display_time,
            'title' => $this->title,
            'author' => $this->author,
            'comment_disabled' => $this->comment_disabled,
            'content' => $this->content,
            'content_short' => $this->content_short,
            'status' => $this->status,
            'forecast' => $this->forecast,
            'image_uri' => $this->image_uri,
            'importance' => $this->importance,
            'pageviews' => $this->pageviews,
            'reviewer' => $this->reviewer,
            'timestamp' => $this->timestamp,
            'type' => $this->type,
        ];
    }

    public function with($request) {
        return [
            'version' => '1.0.0',
            'author_url' => url('http://www.wihz.com.br')
        ];
    }
}
