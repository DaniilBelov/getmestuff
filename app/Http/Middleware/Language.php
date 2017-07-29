<?php

namespace App\Http\Middleware;

use Closure;

class Language
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!in_array($request->segment(1), config('translatable.locales'))) {
            $segments = $request->segments();
            $locale = getLanguagePref();

            if (!in_array($locale, config('translatable.locales'))) {
                $locale = config('app.fallback_locale');
            }

            $segments = array_prepend($segments, $locale);
            return redirect()->to(implode('/', $segments));
        }
        return $next($request);
    }
}
