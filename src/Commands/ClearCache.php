<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\App\CoreCommand;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Clear Cache Command.
 */
class ClearCache extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('clear:cache');
        $this->setDescription('Clear views cache');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = rootPath(config('app.cache_path'));

        if (!$this->filesystem->exists($path)) {
            throw new PathNotFoundException("The path '{$path}' doesn't exist");
        }

        $this->filesystem->removeDir($path);
        $this->filesystem->createDir($path);

        $this->success('Cache was cleared successfully');
    }
}
