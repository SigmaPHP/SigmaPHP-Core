<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\App\CoreCommand;

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
        $path = rootPath(config('app.uploads_path'));

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        // create symbolic link
        // ToDo: make uploads dynamic !!
        $publicPath = rootPath('public');

        if ($this->filesystem->exists("{$publicPath}/uploads")) {
            $this->info("'{$publicPath}/uploads' already exists");

            return;
        }

        exec("ln -s {$path} {$publicPath}/uploads &> /dev/null");

        $this->success("Uploads directory was created successfully");
    }
}
