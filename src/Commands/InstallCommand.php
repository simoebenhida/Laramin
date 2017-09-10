<?php

namespace Simoja\Laramin\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Simoja\Laramin\LaraminServiceProvider;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;
use Simoja\Laramin\Facades\Laramin;

class InstallCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'Laramin:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Install Laramin';

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
        $this->call('migrate:reset');

        $this->info('Publishing the Laramin assets');
        $this->call('vendor:publish', ['--provider' => LaraminServiceProvider::class]);
        foreach(Laramin::getExtraModels() as $key => $model)
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

        // $this->info('Migrating the database tables into your application');
        // $this->call('laratrust:migration');
        $this->info('Dumping the autoloaded files and reloading all new files');

        $composer = $this->findComposer();

        $process = new Process($composer.' dump-autoload');
        $process->setWorkingDirectory(base_path())->run();

        $this->info('Adding Laramin routes to routes/web.php');

        $filesystem->append(
            base_path('routes/web.php'),
            "\n\nRoute::group(['prefix' =>  config('Laramin.prefix')], function () {\n    Laramin::routes();\n});\n"
        );

        // \Route::group(['prefix' =>  config('Laramin.prefix')], function () {
        //     \Laramin::routes();
        // });
        $this->info('Adding Laramin api routes to routes/api.php');

         $filesystem->append(
            base_path('routes/api.php'),
            "\n\nRoute::group(['prefix' =>  config('Laramin.prefix')], function () {\n    Laramin::ApiRoutes();\n});\n"
        );

        // \Route::group(['prefix' =>  config('Laramin.prefix')], function () {
        //     \Laramin::routes();
        // });
        $this->call('migrate');
        $this->call('db:seed');

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
