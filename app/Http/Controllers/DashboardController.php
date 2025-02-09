<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        return match(true) {
            $request->user()->hasRole('admin') => redirect()->route('admin.dashboard'),
            $request->user()->hasRole('user') => redirect()->route('user.dashboard'),
            default => redirect()->route('home'),
        };
    }
}
