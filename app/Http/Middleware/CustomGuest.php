<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CustomGuest
{
    public function handle(Request $request, Closure $next)
    {
        // If logged in and token still valid → redirect away
        if (Auth::check()) {
            $user = Auth::user();

            if ($user->tokenremember && $user->token_expires_at && Carbon::now()->lessThanOrEqualTo($user->token_expires_at)) {
                return redirect()->route('home');
            }
        }

        return $next($request);
    }
}
