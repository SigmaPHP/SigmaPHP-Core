<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

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
        $this->createClass(
            config('app.commands_path'),
            'command',
            $this->getArgument('name')
        );
    }
}
