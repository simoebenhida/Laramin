<?php

namespace Simoja\SLblog\Commands;

use Illuminate\Console\Command;
use Illuminate\Console\DetectsApplicationNamespace;
use Simoja\SLblog\SLBlogServiceProvider;

class SeederCommand extends Command
{
    use DetectsApplicationNamespace;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'SLblog:seed';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Seeder SLblog';

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
    public function handle()
    {
        $this->info('Seeding the SLblog examples');
        $this->call('laratrust:seeder');
        $this->warn('If the command didn\'t work try to run this command : composer dump-autoload');
        $this->error('Add this line on DatabaseSeeder.php $this->call(LaratrustSeeder::class)');
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
