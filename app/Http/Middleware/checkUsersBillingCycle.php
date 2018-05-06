<?php

namespace App\Http\Middleware;

use Closure;

class checkUsersBillingCycle
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
        if ($request->User()->billing_cycle == 'daily') {
           return redirect('/');
        }else{
          return redirect('/subscription');
        }

        return $next($request);
    }
}
