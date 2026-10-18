<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Core\Commands\Base\CoreCommand;

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
        $path = rootPath(config('app.providers_path'));

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        $providerName = $this->getArgument('name');

        // add 'ServiceProvider' automatically if the name doesn't have it
        // and if does , then ignore
        if (stripos($providerName, 'ServiceProvider') === false) {
            $providerName .= 'ServiceProvider';
        }

        $providerFile = concatPath($path, $providerName) . '.php';

        $this->filesystem->create(
            $providerFile,
            str_replace(
                '$className',
                $providerName,
                $this->filesystem->read(
                    concatPath(__DIR__, 'templates', 'provider.php.dist')
                )
            )
        );

        // register the new provider into the 'config/providers.php'
        $providersList = $this->filesystem->read(
            rootPath('config/providers.php')
        );

        // we just add the full class path before the ']'
        $providersList = str_replace(
            ']',
            "    \App\Providers\\" . $providerName . "::class,\n]",
            $providersList
        );

        $this->filesystem->write(
            rootPath('config/providers.php'),
            $providersList
        );

        $this->success(
            "The service provider '{$providerName}' was created successfully"
        );
    }
}
