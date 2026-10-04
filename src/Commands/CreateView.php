<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Create View Command.
 */
class CreateView extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:view');
        $this->setDescription('Create a new view');

        $this->addArgument('name', 'View\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = root_path(config('app.views_path'));

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            throw new PathNotFoundException("The path '{$path}' doesn't exist");
        }

        $viewName = $this->getArgument('name');

        $filesystem->create($path . '/' . $viewName . '.php');

        $this->success(
            "The view '{$viewName}' was created successfully"
        );
    }
}
