<?php

namespace SigmaPHP\Core\App;

use SigmaPHP\Console\App;
use SigmaPHP\Console\DataType;
use SigmaPHP\Console\Option;

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
        $app->setAppVersion('SigmaPHP Framework' . version());

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

        $app->loadCommands(
            rootPath('vendor/sigmaphp/sigmaphp-core/src/Commands'),
            '\SigmaPHP\Core\Commands'
        );

        $app->loadCommands(
            rootPath('vendor/sigmaphp/sigmaphp-db/src/Commands'),
            '\SigmaPHP\DB\Commands'
        );

        $app->run();
    }
}
