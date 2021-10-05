<?php

namespace Samchentw\Permission\Helpers;

class PermissionHelper
{

    public static function getPermissionMapConfig()
    {
        $permission_map = require config_path('permissionmap.php');
        return $permission_map;
    }

    public static function getPermissions()
    {
        $permissions = static::getPermissionMapConfig();
        $groups = $permissions['groups'];

        $pages = $groups['pages'];
        $features = $groups['features'];

        $results = collect([]);
        foreach ($pages as $page) {
            if ($page['permissions']) {
                $detail = collect($page['permissions'])->map(function ($item) use ($page) {
                    return [
                        'group' => $page['label'] . '群組',
                        'label' => $page['label'] . '-' . static::shortNameMap($item),
                        'key' => $page['key'] . '.' . $item,
                    ];
                })->all();

                $results = $results->concat($detail);
                unset($page['permissions']);
                $page['group'] = $page['label'] . '群組';
            }
            $results->push($page);
        }

        $results = $results->concat($features);
        return $results->all();
    }


    private static function shortNameMap($input)
    {
        $dict = [
            'Create' => '新增',
            'Update' => '修改',
            'Delete' => '刪除',
        ];

        return $dict[$input];
    }
}
