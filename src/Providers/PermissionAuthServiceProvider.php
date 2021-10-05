<?php

namespace Samchentw\Permission\Providers;

use Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Gate;
use Illuminate\Auth\Access\Response;
use phpDocumentor\Reflection\DocBlock\Tags\Var_;
use Samchentw\Permission\Helpers\PermissionHelper;
use App\Models\User;

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
                Gate::define($p['key'], function (User $user) use ($p, $enable) {
                    if (!$enable) return true;
                    return $user->havePermission($p['key']) ? Response::allow() : Response::deny('你沒有此權限！');
                });
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
