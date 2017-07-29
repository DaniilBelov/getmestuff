<?php

namespace App\Http\Middleware;

use App\GlobalSettings;
use Closure;

class UnderConstruction
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
        $state = GlobalSettings::getSettings('state')->data['on'];
        $construct = strpos($request->path(), 'construct');

        if (strpos($request->path(), 'admin') !== false) {
            return $next($request);
        } elseif ($state) {
            return $next($request);
        } elseif (!$state && $construct !== false) {
            return $next($request);
        } else {
            return redirect('/'.app()->getLocale().'/construction');
        }
    }
}
