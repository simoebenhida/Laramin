<?php

namespace Simoja\SLblog\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Simoja\SLblog\SLBlogServiceProvider;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;
use Simoja\SLblog\Facades\SLblog as SLblogFacade;

class InstallCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SLblog:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install SLblog';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    protected function findComposer()
    {
        if (file_exists(getcwd().'/composer.phar')) {
            return '"'.PHP_BINARY.'" '.getcwd().'/composer.phar';
        }

        return 'composer';
    }

    public function handle(Filesystem $filesystem)
    {
        $this->info('Publishing the SLblog assets');
        $this->call('vendor:publish', ['--provider' => SLBlogServiceProvider::class]);

        foreach(SLblogFacade::getbackModels() as $key => $model)
        {
            file_put_contents(
                app_path("{$key}.php"),
                $this->compileControllerStub($key)
            );
        }
        //migration
        /**

            TODO:
            - UnComment For Later
         */

        $this->info('Migrating the database tables into your application');
        $this->call('laratrust:migration');
        $this->info('Dumping the autoloaded files and reloading all new files');

        $composer = $this->findComposer();

        $process = new Process($composer.' dump-autoload');
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Adding SLblog routes to routes/web.php');

        $filesystem->append(
            base_path('routes/web.php'),
            "\n\nRoute::group(['prefix' =>  config('SLblog.prefix')], function () {\n    SLblog::routes();\n});\n"
        );

        // \Route::group(['prefix' =>  config('SLblog.prefix')], function () {
        //     \SLblog::routes();
        // });
        $this->info('Adding SLblog api routes to routes/api.php');

         $filesystem->append(
            base_path('routes/api.php'),
            "\n\nRoute::group(['prefix' =>  config('SLblog.prefix')], function () {\n    SLblog::ApiRoutes();\n});\n"
        );

        // \Route::group(['prefix' =>  config('SLblog.prefix')], function () {
        //     \SLblog::routes();
        // });
        $this->call('migrate');
    }

    protected function compileControllerStub($model)
    {
        return str_replace(
            '{{namespace}}',
            $this->getAppNamespace(),
            file_get_contents(__DIR__."/stubs/make/model/{$model}.stub")
        );
    }
}
