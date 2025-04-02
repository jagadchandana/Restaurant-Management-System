<?php

namespace App\Http\Middleware;

use App\Repositories\Eloquent\User\UserInterface;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if ($request->user()) {
            $user = app()->make(UserInterface::class)->findById($request->user()->id);
            if (! $user->hasPermission($role)) {
                return redirect()->back()->with('error', ' 403 Unauthorized action.');
            }
        }
        return $next($request);
    }
}
