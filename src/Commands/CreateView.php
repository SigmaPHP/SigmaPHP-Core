<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\Base\CoreCommand;

/**
 * Create View Command.
 */
class CreateView extends CoreCommand
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
        $path = rootPath(config('app.views_path'));

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        $viewName = $this->getArgument('name');

        $this->filesystem->create(
            concatPath($path, $viewName) . '.template.html'
        );

        $this->success(
            "The view '{$viewName}' was created successfully"
        );
    }
}
