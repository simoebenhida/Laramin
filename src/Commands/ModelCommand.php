<?php

namespace Simoja\Laramin\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Simoja\Laramin\Facades\Laramin;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class ModelCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'Laramin:model';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new Laramin Eloquent model class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Model';

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        if (parent::fire() === false && ! $this->option('force')) {
            return;
        }
    }
    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return __DIR__.'/stubs/make/model/model.stub';
    }
    protected function replaceNamespace(&$stub, $name)
    {
        $stub = str_replace(
            ['DummyNamespace', 'DummyRootNamespace','DummyTable','DummyFillable','DummyTraits'],
            [$this->getNamespace($name), $this->rootNamespace(),$this->getMigrationInput(),$this->fillableColumns($name),$this->DummyTraits()],
            $stub
        );
        return $this;
    }

    protected function fillableColumns($name)
    {
        $model = explode('\\',$name);
        return Laramin::model('DataType')->where('name',$model[1])->first()->infos()->pluck('column');
    }

    protected function DummyTraits()
    {
        if($this->getTags()) {
            return "use Taggable;";
        }
    }

    protected function getTags() {
        return trim($this->argument('tags'));
    }

    protected function getMigrationInput()
    {
        return $this->argument('migration');
    }

    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the class'],
            ['migration', InputArgument::REQUIRED, 'The migration Name'],
            ['tags', InputArgument::REQUIRED, 'Tags.'],
        ];
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace;
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['force', 'f', InputOption::VALUE_NONE, 'Create the class even if the model already exists.'],
            ['migration', 'm', InputOption::VALUE_NONE, 'Create a new migration file for the model.'],
        ];
    }
}
