<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Log;

class LogSuspiciousRequests
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        $ip = $request->header('CF-Connecting-IP') ?? $request->ip();

        // suspicious patterns
        $suspicious = [
            'wordpress',
            'wp-admin',
            'phpmyadmin',
            'xmlrpc.php',
        ];

        // foreach ($suspicious as $pattern) {}
        if ($ip != '127.0.0.1') {
            Log::channel('suspicious')->warning('request info', [
                'real_ip'    => $ip,
                'cf_ip'      => $request->ip(), // Cloudflare proxy IP
                'path'       => $request->path(),
                'full_url'   => $request->fullUrl(),
                'user_agent' => $request->header('User-Agent'),
            ]);
        }



        return $next($request);
    }
}
