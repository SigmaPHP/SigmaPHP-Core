<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Run Command.
 */
class Run extends Command
{
    /**
     * Initialize the command.
     *
     * @return void
     */
    public function init()
    {
        $this->setName('run');
        $this->setDescription('Run the app with PHP built in server');

        $this->addOption('port', 'p', 'Port\'s number');
    }

    /**
     * Execute.
     *
     * @return void
     */
    public function execute()
    {
        $path = root_path('public/');

        $filesystem = new Filesystem();

        if (!$filesystem->exists($path)) {
            throw new PathNotFoundException(
                "The public/ directory doesn't exist"
            );
        }

        // get port from app config/.env or through the option 'port'
        $port = config('app.port', $this->getOption('port'));

        // check if port is valid 4-digits
        if (!empty($port) && !preg_match('/[0-9]{4}/', $port)) {
            throw new \InvalidArgumentException(
                "Invalid port number {$port}"
            );
        }

        // check if the port is open
        $connection = @fsockopen('localhost', $port);
        $healthyPort = $port;

        while (is_resource($connection)) {
            $port += 1;

            $this->warning(
                "The port {$healthyPort} is in use," .
                " {$port} will be used instead!"
            );

            $connection = @fsockopen('localhost', $port);
            $healthyPort = $port;
        }

        exec("php -S localhost:$healthyPort -t public public/index.php");
    }
}
