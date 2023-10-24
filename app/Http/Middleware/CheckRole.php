<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Middleware\Auth;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use App\Http\Controllers\TeacherController;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    // app\Http\Middleware\CheckRole.php
    public function handle($request, Closure $next, $role)
    {
        if (! $request->user()->hasRole($role)) {
            // Redirect user to home page if they don't have the required role
            return redirect('/');
        }
    
        return $next($request);
    }
}   