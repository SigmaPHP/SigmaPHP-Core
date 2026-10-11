<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Create 'Custom Command' Command.
 */
class CreateCommand extends Command
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
        $path = root_path(config('app.commands_path'));

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            throw new PathNotFoundException("The path '{$path}' doesn't exist");
        }

        $commandName = $this->getArgument('name');

        // add 'Command' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($commandName, 'Command') === false) {
            $commandName .= 'Command';
        }

        $commandFile = $path . '/' . $commandName . '.php';

        $filesystem->create($commandFile);
        $filesystem->write($commandFile,
            str_replace(
                '$className',
                $commandName,
                $filesystem->read(__DIR__ . '/templates/command.php.dist')
            )
        );

        $this->success(
            "The command '{$commandName}' was created successfully"
        );
    }
}
