<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Create Uploads Command.
 */
class CreateUploads extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:uploads');
        $this->setDescription('Create a new uploads directory');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = root_path(config('app.uploads_path'));

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            $filesystem->createDir($path);
        }

        // create symbolic link
        $publicPath = root_path('public');

        exec("ln -s {$path} {$publicPath}/uploads &> /dev/null");

        $this->success("Uploads directory was created successfully");
    }
}
