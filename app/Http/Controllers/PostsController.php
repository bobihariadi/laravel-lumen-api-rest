<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
* @OA\Tag(
 *     name="Posts",
 *     description="API Endpoints of Post",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
*/

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

    /**
     * @OA\Get(
     *     path="/posts/index",
     *     summary="List of Post",
     *     operationId="IndexPost",
     *      description="This api to get all posts",
     *     tags={"Posts"},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *      ),
     *      security={{ "apikeyAuth":{} }}     
     * )
     */
    public function index(){
        $post = Post::all();
        return response()->json($post);
    }

    /**
     * @OA\Post(
     *      path="/posts/add",
     *      summary="Add Posts",
     *      operationId="AddPosts",
     *      description="This api to add posts",
     *      tags={"Posts"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SamplePostsInsert")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Posts")
     *      )
     * )
     */
    public function createPost(Request $request){
        $post = Post::create($request->all());
        return response()->json($post);
    }

    /**
     * @OA\Get(
     *      path="/posts/view/{id}",
     *      summary="View Post",
     *      operationId="ViewPossts",
     *      description="This api to view post",
     *      tags={"Posts"},
     *      @OA\Parameter(
     *          ref="#/components/parameters/general--id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Posts")
     *      ),
     *      security={{ "apikeyAuth":{} }}
     * )
     */
    public function viewPost($id){
        // $datenow    = Carbon::now()->format('Y-m-d H:i:s');
        $post = Post::find($id);
        return response()->json($post);
    }

    /**
     * @OA\Delete(
     *      path="/posts/delete/{id}",
     *      summary="Delete Posts",
     *      operationId="DeletePosts",
     *      description="This api to delete posts",
     *      tags={"Posts"},
     *      @OA\Parameter(
     *          ref="#/components/parameters/general--id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Posts")
     *      ),
     *      security={{ "apikeyAuth":{} }}
     * )
     */
    public function deletePost($id){
        $post = Post::find($id);
        $post->delete();
        return response()->json("remove successfully.");
    }

    /**
     * @OA\Put(
     *      path="/posts/edit/{id}",
     *      summary="Update Posts",
     *      operationId="EditUsers",
     *      tags={"Posts"},
     *      @OA\Parameter(
     *          ref="#/components/parameters/general--id"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SamplePostsInsert")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Posts")
     *      ),
     *      security={{ "apikeyAuth":{} }}
     * )
     */
    public function updatePost(Request $request, $id){
        $post = Post::find($id);
        $post->title = $request->input('title');
        $post->body = $request->input('body');
        $post->views = $request->input('views');
        $post->save();
        return response()->json($post);
    }
}
