<?php

namespace Samchentw\Permission\Providers;

use Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Gate;
use Illuminate\Auth\Access\Response;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Samchentw\Permission\Helpers\PermissionHelper;

class PermissionAuthServiceProvider extends ServiceProvider
{

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        $enable = config('permissionmap.enable', false);

        try {
            $permissions = PermissionHelper::getPermissions();

            foreach ($permissions as $p) {
                Gate::define($p['key'], function ($user) use ($p, $enable) {
                    $rolePermission = collect($user->roles)->map(function ($roles) {
                        return $roles->permissions;
                    });
                    $permission = collect($rolePermission)->flatten()->unique();
                    $check = $permission->contains($p['key']);

                    if (!$enable) return true;
                    return $check ? Response::allow() : Response::deny('你沒有此權限！');
                });
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
