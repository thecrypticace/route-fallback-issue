<?php

namespace App\Http\Middleware;

use Closure;
use App\User;

class FakeLoginUser
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
        if (! $request->user()) {
            auth()->login(new User([
                "id" => 1,
                "email" => "test@example.com",
            ]));
        }

        return $next($request);
    }
}
