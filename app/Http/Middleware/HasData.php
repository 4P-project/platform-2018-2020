<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class HasData
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        /** @var \App\User $user */
        $user = $request->user();

        if (($user->first_name && $user->last_name && $user->email)
            || $request->getPathInfo() == '/account/edit') {
            return $next($request);
        }

        return redirect('/account/edit')->with('error',
            'Please fill in all fields');
    }
}
