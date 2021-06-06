<?php

namespace App\Http\Resources\Cms;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'user_id' => $this->user_id,
            'title' => $this->title,
            'authors' => $this->authors,
            'keywords' => $this->keywords,
            'abstract' => $this->abstract,
            'introdution' => $this->introdution,
            'body' => $this->body,
            'references' => $this->references,
            'publish_time' => $this->publish_time,
            'publish_status' => $this->publish_status,
            'comment_status' => $this->comment_status,
        ];
        
    }
}
