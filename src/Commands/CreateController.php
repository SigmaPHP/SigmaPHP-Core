<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Create Controller Command.
 */
class CreateController extends Command
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

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            $filesystem->createDir($path);
        }

        $controllerName = $this->getArgument('name');

        // add 'Controller' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($controllerName, 'Controller') === false) {
            $controllerName .= 'Controller';
        }

        $controllerFile = concatPath($path, $controllerName) . '.php';

        $filesystem->create($controllerFile);
        $filesystem->write($controllerFile,
            str_replace(
                '$className',
                $controllerName,
                $filesystem->read(
                    concatPath(__DIR__, 'templates', 'controller.php.dist')
                )
            )
        );

        $this->success(
            "The controller '{$controllerName}' was created successfully"
        );
    }
}
