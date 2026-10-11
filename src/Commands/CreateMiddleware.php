<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Create Middleware Command.
 */
class CreateMiddleware extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:middleware');
        $this->setDescription('Create a new middleware');

        $this->addArgument('name', 'Middleware\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = root_path(config('app.middlewares_path'));

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            throw new PathNotFoundException("The path '{$path}' doesn't exist");
        }

        $middlewareName = $this->getArgument('name');

        // add 'Middleware' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($middlewareName, 'Middleware') === false) {
            $middlewareName .= 'Middleware';
        }

        $middlewareFile = $path . '/' . $middlewareName . '.php';

        $filesystem->create($middlewareFile);
        $filesystem->write($middlewareFile,
            str_replace(
                '$className',
                $middlewareName,
                $filesystem->read(__DIR__ . '/templates/middleware.php.dist')
            )
        );

        $this->success(
            "The middleware '{$middlewareName}' was created successfully"
        );
    }
}
