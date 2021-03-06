<?php

namespace Bantenprov\Pendaftaran;

use Illuminate\Support\ServiceProvider;
use Bantenprov\Pendaftaran\Console\Commands\PendaftaranCommand;

/**
 * The PendaftaranServiceProvider class
 *
 * @package Bantenprov\Pendaftaran
 * @author  bantenprov <developer.bantenprov@gmail.com>
 */
class PendaftaranServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->routeHandle();
        $this->configHandle();
        $this->langHandle();
        $this->viewHandle();
        $this->assetHandle();
        $this->migrationHandle();
        $this->publicHandle();
        $this->seedHandle();
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('pendaftaran', function ($app) {
            return new Pendaftaran;
        });

        $this->app->singleton('command.pendaftaran', function ($app) {
            return new PendaftaranCommand;
        });

        $this->commands('command.pendaftaran');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'pendaftaran',
            'command.pendaftaran',
        ];
    }

    /**
     * Loading and publishing package's config
     *
     * @return void
     */
    protected function configHandle()
    {
        $packageConfigPath = __DIR__.'/config/config.php';
        $appConfigPath     = config_path('pendaftaran.php');

        $this->mergeConfigFrom($packageConfigPath, 'pendaftaran');

        $this->publishes([
            $packageConfigPath => $appConfigPath,
        ], 'pendaftaran-config');
    }

    /**
     * Loading package routes
     *
     * @return void
     */
    protected function routeHandle()
    {
        $this->loadRoutesFrom(__DIR__.'/routes/routes.php');
    }

    /**
     * Loading and publishing package's translations
     *
     * @return void
     */
    protected function langHandle()
    {
        $packageTranslationsPath = __DIR__.'/resources/lang';

        $this->loadTranslationsFrom($packageTranslationsPath, 'pendaftaran');

        $this->publishes([
            $packageTranslationsPath => resource_path('lang/vendor/pendaftaran'),
        ], 'pendaftaran-lang');
    }

    /**
     * Loading and publishing package's views
     *
     * @return void
     */
    protected function viewHandle()
    {
        $packageViewsPath = __DIR__.'/resources/views';

        $this->loadViewsFrom($packageViewsPath, 'pendaftaran');

        $this->publishes([
            $packageViewsPath => resource_path('views/vendor/pendaftaran'),
        ], 'pendaftaran-views');
    }

    /**
     * Publishing package's assets (JavaScript, CSS, images...)
     *
     * @return void
     */
    protected function assetHandle()
    {
        $packageAssetsPath = __DIR__.'/resources/assets';

        $this->publishes([
            $packageAssetsPath => resource_path('assets'),
        ], 'pendaftaran-assets');
    }

    /**
     * Publishing package's migrations
     *
     * @return void
     */
    protected function migrationHandle()
    {
        $packageMigrationsPath = __DIR__.'/database/migrations';

        $this->loadMigrationsFrom($packageMigrationsPath);

        $this->publishes([
            $packageMigrationsPath => database_path('migrations')
        ], 'pendaftaran-migrations');
    }

    public function publicHandle()
    {
        $packagePublicPath = __DIR__.'/public';

        $this->publishes([
            $packagePublicPath => base_path('public')
        ], 'pendaftaran-public');
    }

    public function seedHandle()
    {
        $packageSeedPath = __DIR__.'/database/seeds';

        $this->publishes([
            $packageSeedPath => base_path('database/seeds')
        ], 'pendaftaran-seeds');
    }
}
