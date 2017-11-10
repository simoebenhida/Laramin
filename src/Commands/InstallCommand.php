<?php

namespace Simoja\Laramin\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Simoja\Laramin\LaraminServiceProvider;
use Symfony\Component\Process\Process;
use Illuminate\Filesystem\Filesystem;
use Simoja\Laramin\Facades\Laramin;
use Symfony\Component\Console\Input\InputOption;

class InstallCommand extends Command
{
    use DetectsApplicationNamespace;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'Laramin:install';
    protected $seedersPath = __DIR__.'/../../publishable/database/seeds/';

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
        $this->info('Publishing the Laramin assets');
        $this->call('vendor:publish', ['--provider' => LaraminServiceProvider::class]);

        $models = collect([
             'User' => \App\User::class,
             'Post' => \App\Post::class,
             'Category' => \App\Category::class,
             'Tag' => \App\Tag::class
             ]);

        foreach($models as $key => $model)
        {
            file_put_contents(
                app_path("{$key}.php"),
                $this->compileControllerStub($key)
            );
        }
        $this->info('Adding Laramin routes to routes/web.php');

        $filesystem->append(
            base_path('routes/web.php'),
            "\n\nRoute::group(['prefix' =>  config('laramin.prefix')], function () {\n    Laramin::routes();\n});\n"
        );
        $this->info('Adding Laramin api routes to routes/api.php');

         $filesystem->append(
            base_path('routes/api.php'),
            "\n\nRoute::group(['prefix' =>  config('laramin.prefix')], function () {\n    Laramin::ApiRoutes();\n});\n"
        );

        $this->info('Migration');
        $this->call('migrate');

        $this->call('storage:link');
    }

    protected function compileControllerStub($model)
    {
        return file_get_contents(__DIR__."/stubs/make/model/{$model}.stub");
    }
}
