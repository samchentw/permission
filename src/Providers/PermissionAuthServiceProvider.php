<?php

namespace Samchentw\Permission\Providers;

use Exception;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Illuminate\Auth\Access\Response;
use Samchentw\Permission\Helpers\PermissionHelper;
use App\Models\User;
use ReflectionClass;
use Samchentw\Permission\Traits\Supports\HasRoles;

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
            $reflectionClass = new ReflectionClass(User::class);
            $useTrits = array_keys($reflectionClass->getTraits());
            $noRoleTrites = !in_array(HasRoles::class, $useTrits);

            foreach ($permissions as $p) {
                Gate::define($p['key'], function (User $user) use ($p, $enable, $noRoleTrites) {
                    if (!$enable) return Response::allow();
                    if ($noRoleTrites) return Response::deny(trans('messages.not_permission'));
                    return $user->havePermission($p['key']) ? Response::allow() : Response::deny(trans('messages.not_permission'));
                });
            }
        } catch (Exception $e) {
            return false;
        }
    }
}
