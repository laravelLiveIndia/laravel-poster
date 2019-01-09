<?php

namespace Laravellive\Poster\Tests;

use Laravellive\Poster\PosterServiceProvider;
use Orchestra\Testbench\TestCase as BaseTestCase;
use Laravellive\Poster\Tests\Dummy\Models\User;

class TestCase extends BaseTestCase
{
    public function setup()
    {
        parent::setUp();
        $this->withoutExceptionHandling();
        $this->artisan('migrate', ['--database' => 'testing']);
        $this->loadFactories();
        $this->loadMigrations();
    }

    protected function loadFactories()
    {
        $this->withFactories(__DIR__ . '/../src/database/factories'); // package factories
        $this->withFactories(__DIR__ . '/dummy/database/factories'); // Test factories
    }

    protected function loadMigrations()
    {
        $this->loadLaravelMigrations(['--database' => 'testing']); // package migrations
        $this->loadMigrationsFrom(__DIR__ . '/dummy/database/migrations'); // test migrations
    }

    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('app.key', 'AckfSECXIvnK5r28GVIWUAxmbBSjTsmF');
        $app['config']->set('database.default', 'testing');
        $app['config']->set('database.connections.testing', [
            'driver'   => 'sqlite',
            'database' => ':memory:',
            'prefix'   => '',
        ]);
    }

    protected function getPackageProviders($app)
    {
        return [PosterServiceProvider::class];
    }

    public function createUser($num = null, $args = [])
    {
        return factory(User::class, $num)->create($args);
    }

    public function authUser()
    {
        $user = $this->createUser();
        $this->actingAs($user);
        return $user;
    }
}
