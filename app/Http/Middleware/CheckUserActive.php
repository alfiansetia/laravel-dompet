<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckUserActive
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->user()->status != 'active') {
            if ($request->ajax() || $request->expectsJson()) {
                return response()->json(['message' => 'Your account is Nonactive!'], 403);
            }
            return redirect()->route('home')->with('error', 'Your account is Nonactive!');
        }
        return $next($request);
    }
}
