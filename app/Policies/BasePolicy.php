<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\Response;

class BasePolicy
{
    protected $module;

    protected $restrict;

    protected array $abilityMap = [
        'getTable' => 'table',
        'getCreate' => 'create',
        'postCreate' => 'save',
        'getUpdate' => 'update',
        'postUpdate' => 'update',
        'postDelete' => 'delete',
        'postDeleteBulk' => 'delete',
    ];

    public function __construct()
    {
        $this->module = request()->route()->getAction('name');
        $this->restrict = config('permision');
    }

    private function accessProtected($user, $permision)
    {
        $role = $user->role ?? 'guest';
        $restrictions = $this->restrict[$role] ?? [];

        if (empty($restrictions)) {
            return false;
        }

        $routeAction = request()->route()->getActionMethod();

        foreach ($restrictions as $prefix => $rule) {
            if ($this->module !== $prefix && ! str_starts_with($this->module, $prefix.'.')) {
                continue;
            }

            if ($rule === false) {
                return true;
            }

            if (is_array($rule)) {
                $action = $this->abilityMap[$routeAction] ?? $routeAction;
                if (isset($rule[$action]) && $rule[$action] === false) {
                    return true;
                }
            }
        }

        return false;
    }

    public function save(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function create(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function update(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function table(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function delete(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function show(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function print(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function penawaran(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function suratTugas(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }

    public function kajiUlang(User $user): Response
    {
        return $this->accessProtected($user, __FUNCTION__) ? Response::deny() : Response::allow();
    }
}
