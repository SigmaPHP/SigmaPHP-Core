<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

/**
 * Create Uploads Command.
 */
class CreateUploads extends CoreCommand
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
        $path = rootPath(config('app.upload_path'));

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        // create symbolic link
        // here 'getFileName' will return the uploads dir's name
        $uploadsDir = concatPath(
            rootPath('public'),
            $this->filesystem->getFileName($path)
        );

        if ($this->filesystem->exists($uploadsDir)) {
            $this->info("The uploads directory already exists");

            return;
        }

        $this->filesystem->symlink($path, $uploadsDir);

        $this->success("Uploads directory was created successfully");
    }
}
