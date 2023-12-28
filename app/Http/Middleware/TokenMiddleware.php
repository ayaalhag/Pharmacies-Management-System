<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class TokenMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!$request->hasHeader('Authorization')) {
            return response()->json(['message' => 'Missing authorization token'], 401);
        }

        $token = $request->header('Authorization');
        if (!$this->isValidToken($token)) {
            return response()->json(['message' => 'Invalid authorization token'], 401);
        }
        return $next($request);
    }
  public function starts_with($haystack, $needle) {
    return strpos($haystack, $needle) === 0;
}
    private function isValidToken($token)
    {
        return str_starts_with($token, 'Bearer ');
    }
 
}
