<?php
namespace Chinkei\LumenHealth;

use Chinkei\LumenHealth\Checks\DbCheck;
use Chinkei\LumenHealth\Checks\DiskSpaceCheck;
use Chinkei\LumenHealth\Checks\FreeDiskSpaceCheck;
use Chinkei\LumenHealth\Checks\DatabaseConnectionCheck;
use Chinkei\LumenHealth\Checks\LoadAvgCheck;
use Chinkei\LumenHealth\Checks\RedisCheck;
use Chinkei\LumenHealth\Checks\ServerLoadCheck;
use Chinkei\LumenHealth\Checks\FreeDiskSpaceTest;
use Illuminate\Support\ServiceProvider;

/**
 * Class LumenHealthServiceProvider
 * @package Chinkei\LumenHealth
 */
class LumenHealthServiceProvider extends ServiceProvider
{
    /**
     * @var  boolean  $defer
     */
    protected $defer = true;

    /**
     * Bootstrap
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/lumen_health.php', 'lumen_health');

        $this->app->singleton(HealthManager::class, function ($app) {
            $checks = $app['config']['lumen_health.checks'];
            $checkInstances = [];
            foreach ( $checks as $key => $class ) {
                $class = '\\Chinkei\\LumenHealth\\Checks\\' . $class;
                $key   = is_integer($key) ? null : $key;
                $checkInstances[] = new $class($key);
            }
            return new HealthManager($checkInstances);
        });

        $this->app->alias(HealthManager::class, 'health_manager');
    }

    /**
     * Get the services provided
     *
     * @return array
     */
    public function provides()
    {
        return [
            HealthManager::class,
            'health_manager',
        ];
    }
}
