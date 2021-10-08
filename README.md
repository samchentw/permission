# Permission
1.create roles table  
2.permission management  
3.Automatically register Laravel Gate


## Installation
`composer require samchentw/permission`


## Laravel


Publish the config file by running: 
```sh
$ php artisan vendor:publish --provider="Samchentw\Permission\PermissionServiceProvider"
```

Create the database table required for this package.
```sh
$ php artisan migrate
```
Run seed, If you want to modify the seed information, please go to data/roles.json
```sh
$ php artisan db:seed --class=RoleSeeder
```

## User table add Role

In the Model

```php
    use Samchentw\Permission\Traits\Supports\HasRoles;

    class User extends Authenticatable
    {
        use HasApiTokens;
        use HasFactory;
        use HasProfilePhoto;
        use Notifiable;
        use TwoFactorAuthenticatable;
        use HasRoles;
```

## Usage
```php
    $user = User::whereId(1);
    // Adding roles to a user
    $rolesIds = [ 1, 2, 3];
    $user->addRolesByIds($rolesIds);

    // remove roles
    $user->deleteRoleByIds($rolesIds);

    // Syncing Associations
    $user->syncRoleByIds($rolesIds);
```
## Registered access
In the config/permissionmap.php

For example:
```php
  "groups" => [
        "pages" => [
            [
                'label' => '角色管理',
                'key' => 'Page.Role',
                'permissions' => ['Create']
            ]
        ],

        "features" => [
            [
                'group' =>'身分權限',
                'label' => '系統-管理員',
                'key' => 'Identity.Admin'
            ],
            [
                'group' =>'身分權限',
                'label' => '系統-會員',
                'key' => 'Identity.Member'
            ]
        ]
    ]
```

Gate will be automatically registered.
```php
    $enable = config('permissionmap.enable', false);
    Gate::define("Page.Role", function (User $user) use ($enable) {
        $permission = collect($user->allPermission());
        $check = $permission->contains("Page.Role");
        if (!$enable) return true;
        return $check ? Response::allow() : Response::deny('你沒有此權限！');
    });

     Gate::define("Page.Role.Create", function (User $user) use ($enable) {
        $permission = collect($user->allPermission());
        $check = $permission->contains("Page.Role.Create");
        if (!$enable) return true;
        return $check ? Response::allow() : Response::deny('你沒有此權限！');
    });

    Gate::define("Identity.Admin", function (User $user) use ($enable) {
        $permission = collect($user->allPermission());
        $check = $permission->contains("Identity.Admin");
        if (!$enable) return true;
        return $check ? Response::allow() : Response::deny('你沒有此權限！');
    });

    Gate::define("Identity.Member", function (User $user) use ($enable) {
        $permission = collect($user->allPermission());
        $check = $permission->contains("Identity.Member");
        if (!$enable) return true;
        return $check ? Response::allow() : Response::deny('你沒有此權限！');
    });

```


