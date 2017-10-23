<?php

namespace Simoja\Laramin;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Simoja\Laramin\Facades\Laramin as LaraminFacade;
use Simoja\Laramin\Http\Middleware\LaraminAdminMiddleware;
use Simoja\Laramin\Http\Middleware\LaraminGuestMiddleware;
use Simoja\Laramin\Http\Middleware\LaraminPermissionMiddleware;

class LaraminServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    protected $configPath;
    protected $publishablePath;


    public function boot(Router $router)
    {

        // $this->loadMigrationsFrom("{$this->publishablePath}/database/migrations/");

        $this->loadViewsFrom(__DIR__.'/views', 'laramin');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadHelpers();

        if (app()->version() >= 5.4) {
            $router->aliasMiddleware('laramin.user', LaraminAdminMiddleware::class);
            $router->aliasMiddleware('laramin.guest', LaraminGuestMiddleware::class);
            $router->aliasMiddleware('laramin.permission', LaraminPermissionMiddleware::class);
        } else {
            $router->middleware('laramin.user', LaraminAdminMiddleware::class);
            $router->middleware('laramin.guest', LaraminGuestMiddleware::class);
            $router->middleware('laramin.permission', LaraminPermissionMiddleware::class);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->configPath = config_path('laramin.php');
        $this->publishablePath = $this->getPublishablePath();
        $this->registerConsoleCommands();

        // $this->mergeConfigFrom($this->configPath, 'Laramin');
        $this->registerConfigs();
        $loader = AliasLoader::getInstance();
        $loader->alias('Laramin', LaraminFacade::class);

        $this->app->singleton('laramin', function ($app) {
            return new Laramin();
        });
        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
        }
    }

    public function registerConfigs()
    {
        $this->mergeConfigFrom(
            dirname(__DIR__).'/publishable/config/laramin.php', 'laramin'
        );
    }

    private function registerPublishableResources()
    {
        $publishable = [
            'laramin' => [
                "{$this->publishablePath}/config/laramin.php" => config_path('laramin.php'),
            ],
            'laratrust' => [
                "{$this->publishablePath}/config/laratrust.php" => config_path('laratrust.php'),
            ],
            'laratrust_seeder' => [
                "{$this->publishablePath}/config/laratrust_seeder.php" => config_path('laratrust_seeder.php'),
            ],
            'laramin_assets' => [
                "{$this->publishablePath}/assets/" => public_path(config('laramin.public_path')),
            ],
            'migrations' => [
                "{$this->publishablePath}/database/migrations/" => database_path('migrations'),
            ],
            'seeds' => [
                "{$this->publishablePath}/database/seeds/" => database_path('seeds'),
            ]
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }
    }

    protected function getPublishablePath()
    {
        return dirname(__DIR__).'/publishable';
    }

    protected function registerConsoleCommands()
    {
        $this->commands(Commands\InstallCommand::class);
        $this->commands(Commands\ModelCommand::class);
        $this->commands(Commands\Migrations\MigrateMakeCommand::class);
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
