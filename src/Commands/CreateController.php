<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

/**
 * Create Controller Command.
 */
class CreateController extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:controller');
        $this->setDescription('Create a new controller');

        $this->addArgument('name', 'Controller\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $this->createClass(
            config('app.controllers_path'),
            'controller',
            $this->getArgument('name')
        );
    }
}
