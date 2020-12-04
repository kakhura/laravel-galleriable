<?php

namespace Kakhura\LaravelGalleriable;

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\File;
use Illuminate\Support\ServiceProvider;

class GalleriableServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Boot the service provider.
     *
     * @return void
     */
    public function boot(Router $router)
    {
        $this->publishConfigs();
        $this->publishMigrations();
    }

    protected function publishConfigs()
    {
        $configPath = __DIR__ . '/../config/kakhura.galleriable.php';
        $this->mergeConfigFrom($configPath, 'kakhura.galleriable');
        $this->publishes([$configPath => config_path('kakhura.galleriable.php')], 'kakhura-galleriable-config');
    }

    protected function publishMigrations()
    {
        $migrationPath = __DIR__ . '/../database/migrations';
        if (File::exists($migrationPath)) {
            $this->publishes([
                $migrationPath => base_path('database/migrations'),
            ], 'kakhura-galleriable-migrations');
        }
    }
}
