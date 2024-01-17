<?php

namespace App\Http\Middleware;

use App\Traits\JsonAPIMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAccountNotVerficationAPI
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
            if (auth()->guard('api')->user()->email_verified_at == 0) {
                try {
                    throw new \JsonException('User Account Not Active Please Active Your Account', 403);
                } catch (\JsonException $e) {
                    return $this->ErrorException($e->getCode(), $e->getMessage());
                }
            }
        }
        return $next($request);
    }
}
