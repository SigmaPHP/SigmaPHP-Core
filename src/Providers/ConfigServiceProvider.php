<?php

namespace SigmaPHP\Core\Providers;

use SigmaPHP\Container\Interfaces\ServiceProviderInterface;
use SigmaPHP\Container\Container;
use SigmaPHP\Core\Config\Config;

/**
 * Config Service Provider Class
 */
class ConfigServiceProvider implements ServiceProviderInterface
{
    /**
     * The boot method , will be called after all
     * dependencies were defined in the container.
     *
     * @param Container $container
     * @return void
     */
    public function boot(Container $container)
    {
        //
    }

    /**
     * Add a definition to the container.
     *
     * @param Container $container
     * @return void
     */
    public function register(Container $container)
    {
        $container->set('config', function () {
            // create new config manager
            $configManager = new Config();

            // set error display
            $configManager->setErrorsDisplay(
                $configManager->get('app.env', 'development')
            );

            // set timezone
            $configManager->setTimezone(
                $configManager->get('app.timezone', 'UTC')
            );

            return $configManager;
        });
    }
}
