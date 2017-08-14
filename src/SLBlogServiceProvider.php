<?php

namespace Simoja\SLblog;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;
use Illuminate\Routing\Router;
use Simoja\SLblog\Facades\SLblog as SLblogFacade;
use Simoja\SLblog\Http\Middleware\SLblogAdminMiddleware;
use Simoja\SLblog\Http\Middleware\SLblogGuestMiddleware;

class SLBlogServiceProvider extends ServiceProvider
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
        $this->loadViewsFrom(__DIR__.'/views', 'slblog');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadHelpers();

        if (app()->version() >= 5.4) {
            $router->aliasMiddleware('admin.user', SLblogAdminMiddleware::class);
            $router->aliasMiddleware('admin.guest', SLblogGuestMiddleware::class);
        } else {
            $router->middleware('admin.user', SLblogAdminMiddleware::class);
            $router->middleware('admin.guest', SLblogGuestMiddleware::class);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->publishablePath = $this->getPublishablePath();
        $this->configPath = config_path('slblog.php');
        $this->registerConsoleCommands();

        $this->mergeConfigFrom($this->configPath, 'SLblog');

        $loader = AliasLoader::getInstance();
        $loader->alias('SLblog', SLblogFacade::class);

        $this->app->singleton('slblog', function ($app) {
            return new SLblog();
        });
        if ($this->app->runningInConsole()) {
            $this->registerPublishableResources();
        }
    }

    private function registerPublishableResources()
    {
        $publishable = [
            'config' => [
                "{$this->publishablePath}/config/slblog.php" => config_path('slblog.php'),
            ],
            'config' => [
                "{$this->publishablePath}/config/laratrust.php" => config_path('laratrust.php'),
            ],
            'config' => [
                "{$this->publishablePath}/config/laratrust_seeder.php" => config_path('laratrust_seeder.php'),
            ],
            'sLblog_assets' => [
                "{$this->publishablePath}/assets/" => public_path(config('SLblog.public_path')),
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
        $this->commands(Commands\SeederCommand::class);
        $this->commands(Commands\ModelCommand::class);
    }

    protected function loadHelpers()
    {
        foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
