<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomAuth
{
    public function handle(Request $request, Closure $next)
    {
        // If not logged in
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Please login first.');
        }

        $user = Auth::user();

        // If token is missing or expired
        if (
            session('tokenremember') !== $user->tokenremember ||
            session('code_login') !== $user->code_login ||
            !$user->token_expires_at ||
            Carbon::now()->greaterThan($user->token_expires_at)
        ) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your session has expired. Please login again.');
        }

        return $next($request);
    }
}
