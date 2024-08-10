<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class IsValidUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        if(Auth::check() && Auth::user()->role == $role){
            return $next($request);
        }elseif(Auth::check() && Auth::user()->role == 'blogger'){
            return redirect()->route('dashboard');
        }elseif(Auth::check() && Auth::user()->role == 'user'){
            return redirect()->route('homepage');
        }else{
            return redirect()->route('loginPage');
        }
    }
}
