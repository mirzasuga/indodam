<?php

namespace App\Http\Middleware;

use App\Role as UserRole;
use App\User;
use Closure;
use Illuminate\Support\Arr;

/**
 * Role middleware class.
 *
 * @author Nafies Luthfi <nafiesL@gmail.com>
 */
class Role
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next, $roleIds)
    {
        if (auth()->check() == false) {
            return $request->expectsJson()
            ? response()->json(['message' => 'Forbidden.'], 403)
            : redirect()->guest(route('login'));
        }

        $roleIds = explode('|', $roleIds);
        $roles = Arr::only(UserRole::toArray(), $roleIds);

        // Cek apakah grup user ada di dalam array $roleIds?
        if (array_key_exists(auth()->user()->role_id, $roles)) {
            return $next($request);
        }

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Forbidden.'], 403);
        }

        flash(trans('auth.role_unauthorized_access', ['path' => $request->path()]), 'error');

        return redirect()->home();
    }
}
