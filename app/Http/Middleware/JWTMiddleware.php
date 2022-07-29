<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use JWTAuth;
use Response;
use Exception;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;


class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $message = '';

        try 
        {
            //check token vlaidation
            JWTAuth::parseToken()->authenticate();

            return $next($request);
        } 
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) 
        {
            //do whatever you want if token is expired
            $message = 'token expired';
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) 
        {
            //do whatever you want if token is invalid
            $message = 'invalid token';
        }
        catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) 
        {
            //do whatever you want if token not present
            $message = 'provide token';
        }

        return response()->json([
            'sucess' => false,
            'message' => $message
        ]);
    }
}
