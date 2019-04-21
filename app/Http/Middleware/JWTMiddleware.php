<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\JWT;

class JWTMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param @import(Request) $request
     * @param Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $token = $request->token;

        if (!$token) {
            return jsonPrint('error', 'token.not.found');
        }

        try {
            $credentials = JWT::decode($token, env('JWT_SECRET'), ['HS256']);
        } catch (ExpiredException $expiredException) {
            return jsonPrint('error', 'token.expired');
        } catch (\Exception $exception) {
            return jsonPrint('error', 'unexpected.error');
        }

        $user = User::find($credentials->sub);
        $request->user = $user;

        return $next($request);
    }
}
