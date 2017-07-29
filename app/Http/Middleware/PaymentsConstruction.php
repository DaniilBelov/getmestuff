<?php

namespace App\Http\Middleware;

use App\GlobalSettings;
use Closure;

class PaymentsConstruction
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
        $state = GlobalSettings::getSettings('turn_on/of_payment_systems')->data['on'];

        if ($state) return $next($request);

        return abort(403, 'Under construction');
    }
}
