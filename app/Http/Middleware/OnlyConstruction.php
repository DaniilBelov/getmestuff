<?php

namespace App\Http\Middleware;

use App\GlobalSettings;
use Closure;

class OnlyConstruction
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

        if ($state) return redirect('/');

        return $next($request);
    }
}
