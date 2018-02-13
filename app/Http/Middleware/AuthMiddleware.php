<?php

namespace App\Http\Middleware;

use Closure;
use App\Admin;

class AuthMiddleware
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
        if($request->session()->has('admin')){
            return $next($request);
        }
        else{
            $_token = $request->input('_token');
            $admin = Admin::where('remember_token','=',$_token)->first();
            if($admin == null){
                return redirect('login');
            }
            else{
                $data = array(
                    'id' => $admin->id,
                    'username' => $admin->username,
                    'nama' => $admin->nama,
                    'level' => $admin->level
                );
                $request->session()->put('admin', $data);
                return $next($request);
            }
        }
    }
}
