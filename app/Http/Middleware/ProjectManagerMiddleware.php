<?php

namespace App\Http\Middleware;

use Closure;

class ProjectManagerMiddleware
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
        if (auth()->check() && (!auth()->user()->freelancer)) {
            return $next($request);
        }

        return back()->with('danger', 'Sorry, you must be signed in as a project manager to view the requested page.')->with('login', true);
    }
}