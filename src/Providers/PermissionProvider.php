<?php

namespace Samchentw\Permission\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;

class PermissionProvider extends ServiceProvider
{

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->mergeConfigFrom(__DIR__.'/../../config/permissionmap.php', 'permissionmap');
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRoutes();
        $this->configurePublishing();
    }

    /**
     * Configure publishing for the package.
     *
     * @return void
     */
    protected function configurePublishing()
    {
        if (!$this->app->runningInConsole()) {
            return;
        }

        $this->publishes([
            __DIR__.'/../../config/permissionmap.php' => config_path('permissionmap.php'),
        ], 'permission-map-config');

        $this->publishes([
            __DIR__ . '/../../database/migrations/2021_05_28_012551_create_roles_table.php' => 
            database_path('migrations/2021_05_28_012551_create_roles_table.php')
        ], 'samchen-permission-migrations');

        $this->publishes([
            __DIR__ . '/../../database/migrations/2021_05_28_012754_create_role_users_table.php' => 
            database_path('migrations/2021_05_28_012754_create_role_users_table.php')
        ], 'samchen-permission-migrations');

        $this->publishes([
            __DIR__ . '/../../database/seeders/RoleSeeder.php' => database_path('seeders/RoleSeeder.php')
        ], 'samchen-permission-seeder');

        $this->publishes([
            __DIR__ . '/../../database/data/roles.json' => database_path('data/roles.json')
        ], 'samchen-permission-seeder');

        $this->publishes([
            __DIR__ . '/../../stubs/app/Models/Role.php' => app_path('Models/Role.php')
        ]);

        $this->publishes([
            __DIR__ . '/../../database/seeders/UserSeeder.php' => database_path('seeders/UserSeeder.php')
        ], 'samchen-permission-seeder');

        $this->publishes([
            __DIR__ . '/../../database/data/users.json' => database_path('data/users.json')
        ], 'samchen-permission-seeder');

       
    }

    /**
     * Configure the routes offered by the application.
     *
     * @return void
     */
    protected function configureRoutes()
    {
        Route::group([
            'namespace' => 'Samchen\Permission\Http\Controllers',
            'domain' => null,
            'prefix' => 'api',
        ], function () {
            $this->loadRoutesFrom(__DIR__ . '/../../routes/role.php');
        });
    }
}
