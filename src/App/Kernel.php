<?php

namespace SigmaPHP\Core\App;

use SigmaPHP\Core\Interfaces\App\KernelInterface;
use SigmaPHP\Container\Container;
use SigmaPHP\Core\Config\Config;
use EnvParser\Parser;
use SigmaPHP\Core\Exceptions\PathNotFoundException;

/**
 * Kernel Class
 */
class Kernel implements KernelInterface
{
    /**
     * @var string framework version
     */
    const SIGMAPHP_FRAMEWORK_VERSION = '0.1.9';

    /**
     * @var Container $container
     */
    private static $container;

    /**
     * Kernel Constructor
     */
    public function __construct()
    {
        // load environment variables (if it exists!)
        if (file_exists(Config::getFullPath('.env'))) {
            (new Parser())->parse(Config::getFullPath('.env'));
        }

        // create DI container and load all service providers
        self::$container = new Container();

        // register providers
        if (!file_exists(Config::getFullPath('config/providers.php'))) {
            throw new PathNotFoundException(
                "The service providers config doesn't exists " .
                Config::getFullPath('config/providers.php')
            );
        }

        self::$container->registerProviders(
            require Config::getFullPath('config/providers.php')
        );

        // define shared template variables in the container
        self::$container->set('shared_template_variables', []);

        // define custom template directives in the container
        self::$container->set('custom_template_directives', []);

        // enable the autowiring for all classes
        self::$container->autowire();
    }

    /**
     * Get the DI container instance from the Kernel.
     *
     * @return Container
     */
    final public static function getContainer()
    {
        return !is_null(self::$container) ?
            self::$container :
            (new self)::$container;
    }

    /**
     * Load configs, routes then run the app.
     *
     * @return void
     */
    final public function init()
    {
        // run the app
        self::$container->get('router')->start();
    }
}
