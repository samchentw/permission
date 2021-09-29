<?php

namespace Samchentw\Permission\Traits\Supports;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Models\Role;
use Gate;


trait HasRoles
{
    public $roleModel = "App\\Models\\Role";

    /**
     * Initialize the trait
     * 
     * @return void
     */
    public function initializeHasRoles()
    {
        $this->with[] = 'roles';
    }

    public function roles(): BelongsToMany
    {
        return $this->belongsToMany($this->roleModel);
    }

    public function allPermission()
    {
        return $this->roles()->get()->map(function (Role $roles) {
            return $roles->permissions;
        })->flatten()
            ->unique()
            ->all();
    }

    public function addRolesByIds($ids)
    {
        $this->roles()->attach($ids);
    }

    public function syncRoleByIds($ids)
    {
        $this->roles()->sync($ids);
    }

    public function deleteRoleByIds($ids)
    {
        $this->roles()->detach($ids);
    }

    public function isAdmin()
    {
        return Gate::allows('Identity.Admin');
    }

    public function isMember()
    {
        return Gate::allows('Identity.Member');
    }
}
