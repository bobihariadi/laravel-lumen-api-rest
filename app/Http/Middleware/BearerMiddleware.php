<?php

namespace App\Http\Middleware;
use App\Models\User;
use Firebase\JWT\JWT;
use Firebase\JWT\ExpiredException;
use Illuminate\Http\Request;

use Closure;
use Exception;

class BearerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $guard = null)
    {
        $token = $request->bearerToken();
        if(strtolower(substr($request->header('authorization'),0,6)) === 'bearer'){//bearer
            try {
                $decoded = JWT::decode($token, env('JWT_SECRET'), array('HS256'));                  
            } catch(ExpiredException $e) {
                return response()->json(["message"=>"Expired Token"], 401);
            } catch(Exception $e) {
                return response()->json(["message"=>"Error Token"], 401);
            }
                
            $cekdata = User::where('jwt_token', $token)->where('email', $decoded->sub)->first();
            if($cekdata){
                return $next($request);
            }
        }
        return response()->json(["message"=>"Unauthorized."], 401);
    }
}
