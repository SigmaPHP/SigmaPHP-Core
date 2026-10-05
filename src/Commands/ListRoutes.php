<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * List Routes Command.
 */
class ListRoutes extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('list:routes');
        $this->setDescription('List all defined routes in the app');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = root_path(config('app.routes_path'));

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            throw new PathNotFoundException("The path '{$path}' doesn't exist");
        }

        d(container('router')->listRoutes());
    }
}
