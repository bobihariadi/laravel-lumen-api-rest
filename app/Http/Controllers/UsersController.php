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
 * @OA\Get(
 *     path="/users/index",
 *     summary="List all users",
 *     operationId="listUsers",
 *     tags={"Users"},
 *     @OA\Response(
 *         response=200,
 *         description="An paged array of users",
 *         @OA\Schema(ref="#/components/schemas/Pets"),
 *         @OA\Header(header="x-next", @OA\Schema(type="string"), description="A link to the next page of responses")
 *     ),
 *     @OA\Response(
 *         response="default",
 *         description="unexpected error",
 *         @OA\Schema(ref="#/components/schemas/Error")
 *     )
 * )
 */

class UsersController extends Controller
{
    

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
    //list user
    public function index(){
        $post = User::all();
        return response()->json($post);
    }

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

    //view user
    public function view($id){
        $user = User::find($id);
        return response()->json($user);
    }

    //delete user
    public function delete($id){
        $user = User::find($id);
        $user->delete();
        return response()->json("remove successfully.");
    }    
}
