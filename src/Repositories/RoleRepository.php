<?php

namespace Samchentw\Permission\Repositories;

use App\Models\Role;
use Samchentw\Common\Repositories\Base\Repository;

class RoleRepository extends Repository
{
    /**
     * @return string
     */
    public function model(): string
    {
        return Role::class;
    }


    /**
     * 取得多個角色
     * @param  array $ids
     * @return array
     */
    public function getRolesByIds($ids)
    {
        return $this->model()::whereIn('id', $ids)->get();
    }

    public function getRolesById($id): Role
    {
        return $this->model()::where('id', $id)->first();
    }
}
