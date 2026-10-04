<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Create Provider Command.
 */
class CreateProvider extends Command
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
        $path = root_path(config('app.providers_path'));

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            throw new PathNotFoundException("The path '{$path}' doesn't exist");
        }

        $providerName = $this->getArgument('name');

        // add 'ServiceProvider' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($providerName, 'ServiceProvider') === false) {
            $providerName .= 'ServiceProvider';
        }

        $providerFile = $path . '/' . $providerName . '.php';

        $filesystem->create($providerFile);
        $filesystem->write($providerFile,
            str_replace(
                '$className',
                $providerName,
                $filesystem->read(__DIR__ . '/templates/provider.php.dist')
            )
        );

        $this->success(
            "The service provider '{$providerName}' was created successfully"
        );
    }
}
