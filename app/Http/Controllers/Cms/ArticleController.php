<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Laravue\Models\Cms\Article;
use App\Http\Resources\Cms\ArticleResource;
use App\Laravue\JsonResponse;
use App\Laravue\Faker;

class ArticleController extends Controller
{
	
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get articles
        $articles = Article::orderBy('id', 'desc')->paginate(10);

        // Return collection of articles as a resource
        return ArticleResource::collection($articles);
		
    }

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function ArticleList()
    {
		$articles = Article::orderBy('created_at', 'asc')->paginate(20);
		$total = Article::count();
		
		$data = [];
		
		foreach ($articles as $item) {
			$row = [
                'id' => $item->id,
                'display_time' => Faker::randomDateTime()->format('Y-m-d H:i:s'),
                'title' => $item->title,
                'author' => Faker::randomString(mt_rand(5, 10)),
                'comment_disabled' => Faker::randomBoolean(),
                'content' => $item->content,
                'content_short' => Faker::randomString(mt_rand(30, 50)),
                'status' => Faker::randomInArray(['deleted', 'published', 'draft']),
                'forecast' => mt_rand(100, 9999) / 100,
                'image_uri' => 'https://via.placeholder.com/400x300',
                'importance' => mt_rand(1, 3),
                'pageviews' => mt_rand(10000, 999999),
                'reviewer' => Faker::randomString(mt_rand(5, 10)),
                'timestamp' => Faker::randomDateTime()->getTimestamp(),
                'type' => Faker::randomInArray(['US', 'VI', 'JA']),
            ];

            $data[] = $row;
		}

        return response()->json(new JsonResponse(['items' => $data, 'total' => $total]));
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $article = $request->isMethod('put') ? Article::findOrFail($request->article_id) : new Article;

        $article->id = $request->input('article_id');
		$article->display_time = $request->input('display_time');
        $article->title = $request->input('title');
		$article->author = $request->input('author');
		$article->status = $request->input('status');
        $article->content = $request->input('content');
		$article->comment_disable = $request->input('comment_disable');
		$article->importance = $request->input('importance');
		$article->image_uri = $request->input('image_uri');

        if($article->save()) {
            return new ArticleResource($article);
        }
        
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function UpdateArticle(Request $request)
    {

        $article->id = $request->input('id');
		$article->display_time = $request->input('display_time');
        $article->title = $request->input('title');
		$article->type = $request->input('type');
		$article->author = $request->input('author');
		$article->content_short = $request->input('content_short');
        $article->content = $request->input('content');
		$article->status = $request->input('status');
		$article->importance = $request->input('importance');
		$article->timestamp = $request->input('timestamp');
		$article->image_uri = $request->input('image_uri');

        if($article->save()) {
            return new ArticleResource($article);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        // Get article
        $article = Article::findOrFail($id);

        // Return single article as a resource
        return new ArticleResource($article);
    }
	
	/**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function ArticleShow($id)
    {
        // Get article
        $article = Article::findOrFail($id);

        return response()->json(new JsonResponse($article));
		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        // Get article
        $article = Article::findOrFail($id);

        if($article->delete()) {
            return new ArticleResource($article);
        }    
    }
}
