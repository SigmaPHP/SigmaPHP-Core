<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\App\CoreCommand;

/**
 * Create 'Custom Command' Command.
 */
class CreateCommand extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:command');
        $this->setDescription('Create a new console command');

        $this->addArgument('name', 'Command\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = rootPath(config('app.commands_path'));

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        $commandName = $this->getArgument('name');

        // add 'Command' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($commandName, 'Command') === false) {
            $commandName .= 'Command';
        }

        $commandFile = concatPath($path, $commandName) . '.php';

        if ($this->filesystem->exists($commandFile)) {
            $this->info(
                "The command '{$commandFile}' already exists"
            );

            return;
        }

        $this->filesystem->create(
            $commandFile,
            str_replace(
                '$className',
                $commandName,
                $this->filesystem->read(
                    concatPath(__DIR__, 'templates', 'command.php.dist')
                )
            )
        );

        $this->success(
            "The command '{$commandName}' was created successfully"
        );
    }
}
