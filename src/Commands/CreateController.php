<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

/**
 * Create Controller Command.
 */
class CreateController extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:controller');
        $this->setDescription('Create a new controller');

        $this->addArgument('name', 'Controller\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = rootPath(config('app.controllers_path'));

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        $controllerName = $this->getArgument('name');

        // add 'Controller' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($controllerName, 'Controller') === false) {
            $controllerName .= 'Controller';
        }

        $controllerFile = concatPath($path, $controllerName) . '.php';

        if ($this->filesystem->exists($controllerFile)) {
            $this->info(
                "The controller '{$controllerName}' already exists"
            );

            return;
        }

        $this->filesystem->create(
            $controllerFile,
            str_replace(
                '$className',
                $controllerName,
                $this->filesystem->read(
                    concatPath(__DIR__, 'templates', 'controller.php.dist')
                )
            )
        );

        $this->success(
            "The controller '{$controllerName}' was created successfully"
        );
    }
}
