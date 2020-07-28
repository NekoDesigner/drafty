<?php 

namespace Nekodev\Drafty\Console;

use Illuminate\Console\GeneratorCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class DraftModelCommand extends GeneratorCommand {

    protected $name = 'make:draft';
    protected $description = 'Create new custom Draft Model';
    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'class';

    /**
     * Replace the class name for the given stub.
     *
     * @param  string  $stub
     * @param  string  $name
     * @return string
     */
    protected function replaceClass($stub, $name)
    {
        $stub = parent::replaceClass($stub, $name);

        return str_replace('{{model}}', $this->argument('name'), $stub);
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        if($this->option('media'))
        {
            // return  base_path('../packages/drafty/src/Console/Stubs/DraftMedia.stub');
            return  base_path('vendor/Nekodev/drafty/src/Console/Stubs/DraftMedia.stub');
        }
        // return  base_path('../packages/drafty/src/Console/Stubs/Draft.stub');
        return  base_path('vendor/Nekodev/drafty/src/Console/Stubs/Draft.stub');
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . '\Drafts';
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the draft.'],
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['media', 'M', InputOption::VALUE_NONE, 'If draft use media library.'],
        ];
    }

}
