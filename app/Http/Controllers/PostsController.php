<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

class PostsController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(){
        $post = Post::all();
        return response()->json($post);
    }

    public function createPost(Request $request){
        $post = Post::create($request->all());
        return response()->json($post);
    }

    public function viewPost($id){
        // $datenow    = Carbon::now()->format('Y-m-d H:i:s');
        $post = Post::find($id);
        return response()->json($post);
    }

    public function deletePost($id){
        $post = Post::find($id);
        $post->delete();
        return response()->json("remove successfully.");
    }

    public function updatePost(Request $request, $id){
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->views = $request->input('views');
        $post->save();
        return response()->json($post);
    }
}
