<?php

namespace App\Http\Middleware;

use Closure;

class HasDonated
{

    /**
     * Handle an incoming request.
     *
     * @param $request
     * @param Closure $next
     * @return mixed
     * @throws \Exception
     */
    public function handle($request, Closure $next)
    {
        if ($request->user()->donated != 1) {
            throw new \Exception('You cannot publish a wish yet');
        }
        return $next($request);
    }
}
