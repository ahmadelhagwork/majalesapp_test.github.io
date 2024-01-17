<?php

namespace App\Http\Middleware;

use App\Traits\JsonAPIMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class VerficationCodeHeader
{
    use JsonAPIMessages;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader("X-verficationcode")) {
            try {
                throw new \JsonException('verficationcode must write in header [X-verficationcode]', 403);
            } catch (\JsonException $e) {
                return $this->ErrorException($e->getCode(), $e->getMessage());
            }
        }
        return $next($request);
    }
}
