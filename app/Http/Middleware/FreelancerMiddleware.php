<?php

namespace App\Http\Middleware;

use Closure;

class FreelancerMiddleware
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
        if (auth()->check() && (auth()->user()->freelancer || auth()->user()->admin)) {
            return $next($request);
        }

        return back()->with('danger', 'Sorry, you must be signed in as a freelanecr to view the requested page.')->with('login', true);
    }
}