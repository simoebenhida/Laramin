<?php

namespace Simoja\Laramin\Commands;


use Illuminate\Support\Str;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Console\Command;

class DeleteCommand extends Command
{
    protected $files;

    protected $signature = 'Laramin:delete {name}';

    protected $description = 'Delete Laramin Model and Migration File';

    protected $paths;

    public function __construct(Filesystem $files)
    {
        parent::__construct();
        $this->paths = collect();
        $this->files = $files;
    }

    public function handle()
    {
        // $name = $this->qualifyClass($this->getNameInput());

        // $path = $this->getPath($name);

        $name = $this->input->getArgument('name');

        $this->modelPath($name);

        //Begin by deleting Model First
        $this->files->delete($this->paths->toArray());

        $this->info('Model And Migration deleted successfully.');
    }

    public function modelPath($name)
    {
        $this->paths->push(app_path(ucfirst($name) . ".php"));
    }

    // /**
    //  * Get the desired class name from the input.
    //  *
    //  * @return string
    //  */
    // protected function getNameInput()
    // {
    //     return trim($this->argument('name'));
    // }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::VALUE_NONE, 'The paths of the class'],
        ];
    }
}
