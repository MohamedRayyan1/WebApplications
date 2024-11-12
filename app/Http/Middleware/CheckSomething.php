<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class CheckSomething
{

    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->user() && auth()->user()->email == 'moRayyan@gmail.com')
        Log::info("before ___ BB".$request->path());
        return $next($request);

        return response()->json('you are not Rayyan');
    }
}
