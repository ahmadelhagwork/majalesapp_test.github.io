<?php

namespace App\Http\Middleware;

use App\Models\User;
use App\Traits\JsonAPIMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckEmailWhenUserResetPassword
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
            if (!$request->hasHeader('x-email')) {
                throw new \JsonException('Email Not Found', 403);
            } else if (!in_array($request->hasHeader('x-email'), collect(User::all())->pluck('email')->all())) {
                throw new \JsonException('This Email Is Not Sign Up', 404);
            }
        } catch (\JsonException $e) {
            return $this->ErrorException($e->getCode(), $e->getMessage());
        }
        return $next($request);
    }
}
