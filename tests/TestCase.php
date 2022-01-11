<?php

namespace Samchentw\Permission\Tests;

use Orchestra\Testbench\TestCase as OrchestraTestCase;
use Samchentw\Permission\PermissionServiceProvider;

class TestCase extends OrchestraTestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }

    protected function getPackageProviders($app)
    {
        return [
            PermissionServiceProvider::class,
        ];
    }

    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);
        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'testbench');
        $app['config']->set('database.connections.testbench', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
        $app['migrator']->path(__DIR__.'/../database/migrations');
        // $app['config']->set('setting.default_provider_name','G');
        // $app['config']->set('setting.customer_provider_name',['A','B']);
        // $app['config']->set('setting.file_path', __DIR__.'/../database/data/settings.json');
    }

    protected function migrate()
    {
        $this->artisan('migrate', ['--database' => 'testbench'])->run();
    }
}
