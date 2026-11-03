<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

/**
 * Create Middleware Command.
 */
class CreateMiddleware extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:middleware');
        $this->setDescription('Create a new middleware');

        $this->addArgument('name', 'Middleware\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $this->createClass(
            config('app.middlewares_path'),
            'middleware',
            $this->getArgument('name')
        );
    }
}
