<?php

namespace App\Http\Middleware;

use App\Traits\JsonAPIMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckAppAPIToken
{
    use JsonAPIMessages;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            if (!$request->hasHeader('x-api-password')) {
                throw new \JsonException("x-api-password must be in header", 403);
            } else {
                if ($request->header('x-api-password') != config('setting.api-token')) {
                    throw new \JsonException("x-api-password not found", 500);
                }
            }
        } catch (\Exception $e) {
            if ($e instanceof \JsonException) {
                return $this->ErrorException($e->getCode(), $e->getMessage());
            }
        }
        return $next($request);
    }
}
