<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPostParams
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next)
    {
        if (!$request->has('milliseconds')) {
            return response()->json(['error' => 'Bad Request', 'message' => 'Missing required parameters'], 400);
        }

        $email = $request->input('email');

        if ($email && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return response()->json(['error' => 'Bad Request', 'message' => 'Invalid email format'], 400);
        }

        return $next($request);
    }
}
