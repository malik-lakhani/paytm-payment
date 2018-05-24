<?php

namespace App\Http\Middleware;

use Closure;
use Session;

class AdminAuthenticate
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
        if(Session::has('username') && Session::get('username') == config('app.admin_username')) {
            return $next($request);
        }

        return redirect('manage/login')->with('error', 'Invalid username or password.');
    }
}
