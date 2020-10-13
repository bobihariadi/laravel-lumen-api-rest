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
