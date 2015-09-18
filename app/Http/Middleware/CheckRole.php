<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\Guard;

class CheckRole
{
    protected $auth;

    public function __construct(Guard $auth){
        $this->auth = $auth;
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $role = null)
    {
        if ($this->auth->user()) {
            if ($request->user()->isRole($role)) {
                return $next($request);
            }
            return \Response::view('errors.restrict',array(),401);
        }
        if ($request->ajax()) {
            return \Response::view('errors.restrict',array(),401);
        } else {
            return redirect()->guest('auth/login');
        }
    }
}
