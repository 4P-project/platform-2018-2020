<?php

namespace App\Http\Middleware;

use Closure;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var \App\User $user */
        $user = $request->user();

        if ($user->is_admin) {
            return $next($request);
        }

        \Illuminate\Support\Facades\Log::emergency('ADMIN REQUEST: ' . $request->ip() . ' ' . $user->toJson());
        return abort(404);
    }
}
