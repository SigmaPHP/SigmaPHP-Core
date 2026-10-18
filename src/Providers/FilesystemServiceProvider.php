<?php

namespace SigmaPHP\Core\Providers;

use SigmaPHP\Container\Interfaces\ServiceProviderInterface;
use SigmaPHP\Container\Container;
use SigmaPHP\Filesystem\Filesystem;

/**
 * Filesystem Service Provider Class
 */
class FilesystemServiceProvider implements ServiceProviderInterface
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
        $container->set('filesystem', function (Container $container) {
            return (new Filesystem());
        });
    }
}
