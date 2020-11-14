<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Cms\ArticleImageController;
use App\Http\Resources\Cms\ArticleResource;
use App\Laravue\Models\Cms\Article;
use Illuminate\Http\Request;
use App\Laravue\JsonResponse;
use Validator;

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
        $articles = Article::with('article_images')->orderBy('created_at', 'desc')->paginate(20);
        $total = Article::count();

        // Return collection of articles as a resource
        // return ArticleResource::collection($articles);
        return response()->json(new JsonResponse(['items' => $articles, 'total' => $total]));
        // return ArticleResource::collection(Article::all());
		
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*
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
        */

        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $article = Article::create([
                'title' => $params['title'],
                'user_id'=> '1',
                'authors' => $params['authors'],
                'keywords' => $params['keywords'],
                'abstract' => $params['abstract'],
                'introduction' => $params['introduction'],
                'body' => $params['body'],
                'references' => $params['references'],
                'publish_time' => $params['publish_time'],
                'publish_status' => $params['publish_status'],
                'comment_status' => $params['comment_status'],
            ]);
        }

            return new ArticleResource($article);
        
    }
	
	/**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Article $article)
    {

        if ($article === null) {
            return response()->json(['error' => 'Article not found'], 404);
        }

        $validator = Validator::make(
            $request->all(),
            [
                'title' => ['required']
            ]
        );

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 403);
        } else {
            $params = $request->all();
            $article->title = $params['title'];
            $article->user_id = '1';
            $article->authors = $params['authors'];
            $article->keywords = $params['keywords'];
            $article->abstract = $params['abstract'];
            $article->introduction = $params['introduction'];
            $article->body = $params['body'];
            $article->references = $params['references'];
            $article->publish_time = $params['publish_time'];
            $article->publish_status = $params['publish_status'];
            $article->comment_status = $params['comment_status'];
            $article->save();
        }

        return new ArticleResource($article);

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
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Article $article)
    {
        try {
            $article->delete();
        } catch (\Exception $ex) {
            response()->json(['error' => $ex->getMessage()], 403);
        }

        return response()->json(null, 204);

    }

    /**
     * Count the specified resource.
     *
     * @param  \App\Laravue\Models\Crm\Article  $article
     * @return \Illuminate\Http\Response
     */
    public function countarticles()
    {
        $total = Article::count();
        return response()->json($total);
    }
}
