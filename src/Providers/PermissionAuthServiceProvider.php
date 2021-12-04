<?php

namespace Samchentw\Permission\Providers;

use Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
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

                    return $user->havePermission($p['key']) ? Response::allow() : Response::deny(trans('messages.not_permission'));
                });
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
