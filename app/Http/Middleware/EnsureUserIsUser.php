<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureUserIsUser
{
    public function handle(Request $request, Closure $next): Response
    {
  // Check if the user is authenticated and has the 'user' role
  if (Auth::check() && Auth::user()->hasRole('user')) {
    return $next($request);
}

// Redirect unauthorized users
return redirect()->route('home')->with('error', 'You do not have access to this page.');    }
}
