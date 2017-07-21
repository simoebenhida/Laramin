<?php

namespace Simoja\SLblog;

use Illuminate\Support\ServiceProvider;

class SLBlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
          $this->loadViewsFrom(__DIR__.'/views', 'slblog');
          $this->loadRoutesFrom(__DIR__.'/routes.php');
          $this->loadHelpers();
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->registerPublishableResources();
    }

   private function registerPublishableResources()
    {
        $publishablePath = dirname(__DIR__).'/publishable';
        $configPath = "{$publishablePath}/config/slblog.php";

       $this->mergeConfigFrom($configPath, 'SLblog');

        $publishable = [
            'config' => [
                "{$publishablePath}/config/slblog.php" => config_path('slblog.php'),
            ],
            'css' => [
                "{$publishablePath}/assets" => public_path(config('SLblog.public_path')),
            ]
        ];

        foreach ($publishable as $group => $paths) {
            $this->publishes($paths, $group);
        }

    }

    protected function loadHelpers()
    {
         foreach (glob(__DIR__.'/Helpers/*.php') as $filename) {
            require_once $filename;
        }
    }
}
