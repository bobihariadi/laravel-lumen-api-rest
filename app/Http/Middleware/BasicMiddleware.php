<?php

namespace App\Http\Middleware;
use App\Models\User;

use Closure;

class BasicMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

     /**
     * @OA\SecurityScheme(
     *     type="http",
     *     description="Login with username and password to get the authentication token",
     *     name="Basic Authentication",
     *     scheme="basic",
     *     securityScheme="basicAuth",
     * )
     */
    public function handle($request, Closure $next)
    {
        if(strtolower(substr($request->header('authorization'),0,5)) === 'basic'){//basic  
            $cekdata =  User::where('api_token', $request->header('php-auth-pw'))->where('email', $request->header('php-auth-user'))->first();
            if($cekdata){
                return $next($request);
            }
        }
        return response('Unauthorized.', 401);
    }
}
