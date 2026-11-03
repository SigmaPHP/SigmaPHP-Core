<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\CoreCommand;

/**
 * Create View Command.
 */
class CreateView extends CoreCommand
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('create:view');
        $this->setDescription('Create a new view');

        $this->addArgument('name', 'View\'s name');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $this->createClass(
            config('app.views_path'),
            'view',
            $this->getArgument('name'),
            true,
            true,
            'template.html'
        );
    }
}
