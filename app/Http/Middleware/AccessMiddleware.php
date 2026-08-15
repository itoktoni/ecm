<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AccessMiddleware
{
    protected array $abilityMap = [
        'getTable' => 'view',
        'getCreate' => 'save',
        'postCreate' => 'save',
        'getUpdate' => 'save',
        'postUpdate' => 'save',
        'postDelete' => 'delete',
        'postDeleteBulk' => 'delete',
    ];

    /**
     * Handle an incoming request.
     * Implement role-based access control based on RoleEnum.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        if (! $user) {
            return redirect()->route('login');
        }

        $routeName = $request->route()->getName();

        if ($this->isRestricted($user, $routeName)) {
            abort(403, 'Unauthorized action.');
        }

        return $next($request);
    }

    /**
     * Check if the current route is restricted for the user's role.
     */
    protected function isRestricted($user, ?string $routeName): bool
    {
        if (! $routeName) {
            return false;
        }

        $role = $user->role ?? 'guest';
        $restrictions = config("permision.{$role}", []);

        if (empty($restrictions)) {
            return false;
        }

        foreach ($restrictions as $prefix => $rule) {
            if ($routeName !== $prefix && ! str_starts_with($routeName, $prefix.'.')) {
                continue;
            }

            if ($rule === false) {
                return true;
            }

            if (is_array($rule)) {
                $routeAction = request()->route()->getActionMethod();
                $ability = $this->abilityMap[$routeAction] ?? $routeAction;

                if (isset($rule[$ability]) && $rule[$ability] === false) {
                    return true;
                }
            }
        }

        return false;
    }
}
