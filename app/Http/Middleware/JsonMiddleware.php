<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class JsonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!$request->isJson())
            return new JsonResponse(['message' => 'JSON request needed'], 406);
        
        return $next($request);
    }
}