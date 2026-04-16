<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsStaff
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!auth()->check()) {
            return redirect('/login')->with('error', 'Vui lòng đăng nhập');
        }

        if (!auth()->user()->isStaff() && !auth()->user()->isAdmin()) {
            return abort(403, 'Chỉ nhân viên có thể truy cập');
        }

        return $next($request);
    }
}
