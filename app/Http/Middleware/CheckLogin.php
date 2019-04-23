<?php

namespace App\Http\Middleware;

use Closure;

class CheckLogin
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
        if ( $request->ajax() ) {
            if (!session('login_token') ) {
                  return response()->json(['code'=>0,'msg'=>'页面过期,刷新重新登录']);
            }
        }

        if (!session('login_token') ) {
            return redirect('login');
        }
        return $next($request);
    }
}
