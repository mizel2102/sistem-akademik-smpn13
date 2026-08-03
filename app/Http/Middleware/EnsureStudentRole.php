<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentRole
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (! $user) {
            abort(403, 'User does not have the right roles.');
        }

        if ($user->hasRole('student') || $user->student) {
            return $next($request);
        }

        abort(403, 'User does not have the right roles.');
    }
}
