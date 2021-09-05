<?php

namespace Samchentw\Permission\Traits\Supports;

use Gate;

trait HasRoles
{
    public $roleModel = "App\\Models\\Role";

    public function roles()
    {
        return $this->belongsToMany($this->roleModel);
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