<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\App\CoreCommand;

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
        $viewFile = concatPath($path, $viewName) . '.template.html';

        if ($this->filesystem->exists($viewFile)) {
            $this->info(
                "The view '{$viewName}' already exists"
            );

            return;
        }

        $this->filesystem->create($viewFile);

        $this->success(
            "The view '{$viewName}' was created successfully"
        );
    }
}
