<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    public function handle($request, Closure $next)
    {
        $locale = $request->header('lang');

        if (in_array($locale, ['en','ar'])) {
            app()->setLocale($locale);
        }

        return $next($request);
    }
}
