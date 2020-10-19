<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Firebase\JWT\JWT;

/**
* @OA\Tag(
 *     name="Users",
 *     description="API Endpoints of User",
 *     @OA\ExternalDocumentation(
 *         description="Find out more",
 *         url="http://swagger.io"
 *     )
 * )
*/

/**
 * @OA\Parameter(
 *      parameter="general--id",
 *      in="path",
 *      name="id",
 *      required=true,
 *      description="Parameter id should be in integer",
 *      @OA\Schema(
 *          type="integer"
 *      )
 * )
 */


class UsersController extends Controller
{
    
    /**
     * @OA\Post(
     *     path="/users/sampleJwt",
     *     summary="Sample Bearer Auth used JWT",
     *     operationId="BearerUsers",
     *     tags={"Users"},
     *     description="This Api to get Sample Bearer Auth used JWT",
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *      ),
     *      security={{ "bearerAuth":{} }}     
     * )
     */
    public function sampleJwt(Request $request){
        $token = $request->bearerToken();
        $decoded = JWT::decode($token, env('JWT_SECRET'), array('HS256'));
        return (array)$decoded;
    }

    public function jwt(Request $request){
        
       $payload = [
            'iss' => "bearer", // Issuer of the token
            'sub' => $request['email'], // Subject of the token
            'exp' => time() + 60*60*12 // Expiration time
        ];
       $jwt = JWT::encode($payload, env('JWT_SECRET'));

       $decoded = JWT::decode($jwt, env('JWT_SECRET'), array('HS256'));

       $return['encode']= $jwt;
       $return['decoded']= $decoded;
       return $return;

    }

    /**
     * @OA\Get(
     *     path="/users/index",
     *     summary="List all users",
     *     operationId="listUsers",
     *     description="This api to get all users",
     *     tags={"Users"},
     *      @OA\Response(
     *          response=200,
     *          description="successful operation"
     *      )
     * )
     */
    //list user
    public function index(){
        $post = User::all();
        return response()->json($post);
    }

    /**
     * @OA\Post(
     *      path="/users/add",
     *      summary="Add User",
     *      operationId="AddUsers",
     *      description="This api to add users",
     *      tags={"Users"},
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SampleUsersUpdate")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Users")
     *      )
     * )
     */
    //create new user
    public function add(Request $request){
        //create JWT
        $payload = [
            'iss' => "bearer", // Issuer of the token
            'sub' => $request['email'], // Subject of the token
            'exp' => time() + 60*60*12 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        $request['jwt_token']   = JWT::encode($payload, env('JWT_SECRET'));
        $request['api_token']   = Str::random(60);
        $request['password']    = Hash::make($request['password']);  
        $user = User::create($request->all());

        return response()->json($user);
    }

    /**
     * @OA\Put(
     *      path="/users/edit/{id}",
     *      summary="Update User",
     *      operationId="EditUsers",
     *      description="This api to edit users",
     *      tags={"Users"},
     *      @OA\Parameter(
     *          ref="#/components/parameters/general--id"
     *      ),
     *      @OA\RequestBody(
     *          required=true,
     *          @OA\JsonContent(ref="#/components/schemas/SampleUsersUpdate")
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Users")
     *      ),
     *      security={{ "basicAuth":{} }}
     * )
     */
    //update user
    public function edit(Request $request, $id){
        $user = User::find($id);

        //update JWT
        $payload = [
            'iss' => "bearer", // Issuer of the token
            'sub' => $request['email'], // Subject of the token
            'exp' => time() + 60*60*12 // Expiration time
        ];
         $request['jwt_token']   = JWT::encode($payload, env('JWT_SECRET'));

        $user->update($request->all());

        return response()->json($user);
    }

    /**
     * @OA\Get(
     *      path="/users/view/{id}",
     *      summary="View User",
     *      operationId="ViewUsers",
     *      description="this api to view user",
     *      tags={"Users"},
     *      @OA\Parameter(
     *          ref="#/components/parameters/general--id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Users")
     *      ),
     *      security={{ "basicAuth":{} }}
     * )
     */
    //view user
    public function view($id){
        $user = User::find($id);
        return response()->json($user);
    }

    /**
     * @OA\Delete(
     *      path="/users/delete/{id}",
     *      summary="Delete User",
     *      operationId="DeleteUsers",
     *      description="This api to delete users",
     *      tags={"Users"},
     *      @OA\Parameter(
     *          ref="#/components/parameters/general--id"
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="successful operation",
     *          @OA\JsonContent(ref="#/components/schemas/Users")
     *      ),
     *      security={{ "basicAuth":{} }}
     * )
     */
    //delete user
    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return response()->json("remove successfully.");
    }    
}
