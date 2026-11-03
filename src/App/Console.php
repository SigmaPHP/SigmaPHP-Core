<?php

namespace SigmaPHP\Core\App;

use SigmaPHP\Console\App;
use SigmaPHP\Console\DataType;
use SigmaPHP\Console\Option;
use SigmaPHP\Filesystem\Filesystem;

/**
 * Console Class
 */
class Console
{
    /**
     * Create and start a new console app.
     *
     * @return void
     */
    public static function start()
    {
        $app = new App();

        $app->setAppName('sigma-cli');
        $app->setAppDescription('CLI utilities for `SigmaPHP` Framework');
        $app->setAppVersion('SigmaPHP Framework ' . version());

        $app->addGlobalOption(
            'config',
            '',
            'Set config file path',
            Option::PARAMETER_OPTIONAL,
            DataType::STRING,
            rootPath('config/database.php'),
        );

        $app->getGlobalOption('config')->setValue(
            rootPath('config/database.php')
        );

        // core commands
        $app->loadCommands(
            rootPath('vendor/sigmaphp/sigmaphp-core/src/Commands'),
            '\SigmaPHP\Core\Commands',
            [
                'CoreCommand',
                'command.php',
                'controller.php',
                'middleware.php',
                'service_provider.php',
            ]
        );

        // DB commands
        $app->loadCommands(
            rootPath('vendor/sigmaphp/sigmaphp-db/src/Commands'),
            '\SigmaPHP\DB\Commands',
            [
                'DbCommand',
                'CreateConfig',
                'add_column_migration.php',
                'create_table_migration.php',
                'database.php',
                'migration.php',
                'model.php',
                'seeder.php',
            ]
        );

        // user defined commands
        if (container('filesystem')->exists(
            rootPath(config('app.commands_path')))
        ) {
            $filesystem = container()->get('filesystem');

            foreach ($filesystem->list(
                rootPath(config('app.commands_path'))
                , true, false, true) as $command
            ) {
                $app->addCommand(createNamespace($command));
            }
        }

        $app->run();
    }
}
