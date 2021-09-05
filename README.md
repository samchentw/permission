# Permission
todo...


## Installation
`composer require samchentw/permission`


## Laravel
After updating composer, add the ServiceProvider to the providers array in config/app.php
```sh
Samchentw\Permission\Providers\PermissionProvider::class,
Samchentw\Permission\Providers\PermissionAuthServiceProvider::class
```

Publish the config file by running: 
```sh
$ php artisan vendor:publish --provider="Samchentw\Permission\Providers\PermissionProvider"
```

## Feature
todo...
