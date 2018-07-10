<?php

namespace App\Http\Middleware;

use Closure;

class NotPass
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
        if ($request->session()->exists('id')) {
          return redirect('dashboard');
        }
        return $next($request);
    }
}
