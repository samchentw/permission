<?php

namespace Samchentw\Permission\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Samchentw\Permission\Repositories\RoleRepository;
use Gate;
use Samchentw\Permission\Helpers\PermissionHelper;

class RoleController extends Controller
{
    private $roleRepository;

    public function __construct(RoleRepository $RoleRepository)
    {
        $this->roleRepository = $RoleRepository;
    }

    /**
     * @group RoleController(角色)
     * Role1 取得所有角色
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAll()
    {
        return $this->roleRepository->getAll();
    }



    /**
     * @group RoleController(角色)
     * Role2 取得角色
     *
     * @param  string $id
     * @return \Illuminate\Http\Response
     */
    public function get($id)
    {
        return $this->roleRepository->getById($id);
    }

    /**
     * @group RoleController(角色)
     * Role3 建立角色
     *
     * @bodyParam  name string required 
     * @bodyParam  description string 
     * @bodyParam permissions string[] required 
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['string', 'required'],
            'description' => ['string', 'nullable'],
            'permissions' => ['array', 'nullable'],
            'permissions.*' => ['string']
        ]);

        $permission = $request->get('permissions', []);
        $request->merge(['permission' => $permission]);

        $this->roleRepository->create($request->only([
            "name", "description", "is_default", "permissions"
        ]));
    }

    /**
     * @group RoleController(角色)
     * Role4 修改角色
     *
     * @bodyParam  name string  
     * @bodyParam  description string  
     * @bodyParam permissions string[]  
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['string', 'nullable'],
            'description' => ['string', 'nullable'],
            'permissions' => ['array', 'nullable'],
            'permissions.*' => ['string']
        ]);
        $body = $request->only([
            "name", "description", "is_default", "permissions"
        ]);
        $this->roleRepository->update(array_filter($body), $id);
    }

    /**
     * @group RoleController(角色)
     * Role5 刪除角色
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $this->roleRepository->destroy($id);
    }

    /**
     * @group RoleController(角色)
     * Role6 取得所有permission
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function getAllPermission(Request $request)
    {
        $permissionMap = PermissionHelper::getPermissions();
        $grouped = collect($permissionMap)->groupBy('group')->all();

        return response()->json([
            'permissions' => $permissionMap,
            'groups' => $grouped
        ]);;
    }
}
