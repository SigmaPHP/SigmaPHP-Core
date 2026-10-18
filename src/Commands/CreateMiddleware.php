<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\App\CoreCommand;

/**
 * Create Middleware Command.
 */
class CreateMiddleware extends CoreCommand
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
        $path = rootPath(config('app.middlewares_path'));

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        $middlewareName = $this->getArgument('name');

        // add 'Middleware' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($middlewareName, 'Middleware') === false) {
            $middlewareName .= 'Middleware';
        }

        $middlewareFile = concatPath($path, $middlewareName) . '.php';

        $this->filesystem->create(
            $middlewareFile,
            str_replace(
                '$className',
                $middlewareName,
                $this->filesystem->read(
                    concatPath(__DIR__, 'templates', 'middleware.php.dist')
                )
            )
        );

        $this->success(
            "The middleware '{$middlewareName}' was created successfully"
        );
    }
}
