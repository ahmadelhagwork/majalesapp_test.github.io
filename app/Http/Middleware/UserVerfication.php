<?php

namespace App\Http\Middleware;

use App\Traits\JsonAPIMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserVerfication
{
    use JsonAPIMessages;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->guard('api')->check()) {
            if (auth()->guard('api')->user()->email_verified_at == 1) {
                try {
                    throw new \JsonException('User Account Is Active', 201);
                } catch (\JsonException $e) {
                    return $this->ErrorException($e->getCode(), $e->getMessage());
                }
            }
        }
        return $next($request);
    }
}
