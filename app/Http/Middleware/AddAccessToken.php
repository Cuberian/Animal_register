<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class AddAccessToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        dump($request);
        if ($request->has('access_token')) {
            $request->headers->set('Authorization', 'Bearer ' . $request->input('access_token'));
        }

        return $next($request);
    }
}
