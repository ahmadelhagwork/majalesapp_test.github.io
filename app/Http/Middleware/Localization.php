<?php

namespace App\Http\Middleware;

use App\Traits\GeneralMethods;
use App\Traits\JsonAPIMessages;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Localization
{
    use JsonAPIMessages, GeneralMethods;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->hasHeader('X-localization')) {
            try {
                throw new \JsonException('You Must Choose Language', 403);
            } catch (\JsonException $e) {
                return $this->ErrorException($e->getCode(), $e->getMessage());
            }
        } else {
            $lang = $request->header('X-localization');

            if (!in_array($lang, array_keys($this->LanguageApp()))) {
                try {
                    throw new \JsonException('This Language Not Exit In App', 500);
                } catch (\JsonException $e) {
                    return $this->ErrorException($e->getCode(), $e->getMessage());
                }
            }
            app()->setLocale($lang);
        }
        return $next($request);
    }
}
