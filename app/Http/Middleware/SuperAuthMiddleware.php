<?php

namespace App\Http\Middleware;

use Closure;

class SuperAuthMiddleware
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
        $admin = $request->session()->get('admin');
        if($admin['level'] == 1) return $next($request);
        else return redirect('dashboard');
    }
}
