<?php

namespace App\Http\Controllers\Cms;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\Cms\PostResource;
use App\Laravue\Models\Cms\Post;

class PostController extends Controller
{

    public function index()
    {
      	// Get leads
        $posts = Post::paginate(15);
		
        // Return collection of leads as a resource
        return PostResource::collection($posts);
    }

	public function store(Request $request)
    {
      $post = new Post([
        'title' => $request->get('title'),
        'body' => $request->get('body')
      ]);

      $post->save();

      return response()->json('successfully added');
    }
	
    public function edit($id)
    {
      $post = Post::find($id);
      return response()->json($post);
    }

    public function update($id, Request $request)
    {
      $post = Post::find($id);

      $post->update($request->all());

      return response()->json('successfully updated');
    }

    public function delete($id)
    {
      $post = Post::find($id);

      $post->delete();

      return response()->json('successfully deleted');
    }
}
