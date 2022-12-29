<?php

namespace App\Infrastructure\Laravel\Middleware;

use Closure;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;

class BusinessAuthMiddleware extends BaseMiddleware
{

    public function handle($request, Closure $next)
    {
        $user = Auth::user();
        if (!$user->business->contains('id', $request->business_id)){
            return response()->json(['status' => 'error', 'message' => 'Business not belog to user'], JsonResponse::HTTP_UNAUTHORIZED);
        }
        return $next($request);
    }
}
