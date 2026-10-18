<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\App\CoreCommand;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Test Command.
 */
class Test extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('test');
        $this->setDescription('Run unit tests');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = rootPath('tests/');

        if (!$this->filesystem->exists($path)) {
            throw new PathNotFoundException(
                "The {$path} directory doesn't exist"
            );
        }

        exec(rootPath('vendor/bin/') . "phpunit tests");
    }
}
