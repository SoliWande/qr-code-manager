<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        $user = $request->user();

        if (!$user) {
            abort(403, 'Bạn chưa đăng nhập.');
        }

        if ($user->isAdmin()) {
            return $next($request);
        }

        if (!$user->hasRole($roles)) {
            abort(403, 'Bạn không có quyền sử dụng chức năng này.');
        }

        return $next($request);
    }
}
