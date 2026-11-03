<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

/**
 * Create Provider Command.
 */
class CreateProvider extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:provider');
        $this->setDescription('Create a new service provider');

        $this->addArgument('name', 'Service provider\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $this->createClass(
            config('app.providers_path'),
            'service provider',
            $this->getArgument('name'),
            false,
            false,
            'php',
            rootPath('config/providers.php')
        );
    }
}
