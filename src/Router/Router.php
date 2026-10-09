<?php

namespace SigmaPHP\Core\Router;

use SigmaPHP\Core\Interfaces\Router\RouterInterface;
use SigmaPHP\Filesystem\Filesystem;
use SigmaPHP\Router\Interfaces\PageNotFoundHandlerInterface;
use SigmaPHP\Router\Interfaces\StaticAssetsHandlerInterface;

/**
 * Router Class
 */
class Router implements RouterInterface
{
    /**
     * @var object $routerEngine
     */
    private $routerEngine;

    /**
     * @var string $routeFilesPath
     */
    private $routeFilesPath;

    /**
     * @var array $routes
     */
    private $routes;

    /**
     * Router Constructor
     *
     * @param string $routeFilesPath
     */
    public function __construct($routeFilesPath)
    {
        $this->routeFilesPath = $routeFilesPath;
        $this->routes = [];
    }

    /**
     * Set the router engine (the actual Router).
     *
     * @param object $routerEngine
     * @return void
     */
    public function setRouterEngine($routerEngine)
    {
        $this->routerEngine = $routerEngine;
    }

    /**
     * Load routes from all routes files.
     *
     * @return void
     */
    public function loadRoutes()
    {
        foreach ((new Filesystem())->list($this->routeFilesPath, true, true)
            as $file
        ) {
            $this->routes += require $file;
        }
    }

    /**
     * Add routes.
     *
     * @param array $routes
     * @return void
     */
    public function addRoutes($routes)
    {
        $this->routerEngine->addRoutes($routes);
    }

    /**
     * List all registered routes.
     *
     * @return array
     */
    public function listRoutes()
    {
        return $this->routerEngine->listRoutes();
    }

    /**
     * Generate URL from route's name.
     *
     * @param string $routeName
     * @param array $parameters
     * @return string
     */
    public function url($routeName, $parameters = [])
    {
        return $this->routerEngine->url($routeName, $parameters);
    }

    /**
     * Set page not found handler.
     *
     * @param PageNotFoundHandlerInterface $handler
     * @return void
     */
    public function setPageNotFoundHandler($handler)
    {
        $this->routerEngine->setPageNotFoundHandler($handler);
    }

    /**
     * Get base URL.
     *
     * @return string
     */
    public function getBaseUrl()
    {
        return $this->routerEngine->getBaseUrl();
    }

    /**
     * Set static assets route path.
     *
     * @param string $path
     * @return void
     */
    public function setStaticAssetsRoutePath($path)
    {
        return $this->routerEngine->setStaticAssetsRoutePath($path);
    }

    /**
     * Set static assets route handler.
     *
     * @param StaticAssetsHandlerInterface $handler
     * @return void
     */
    public function setStaticAssetsRouteHandler($handler)
    {
        return $this->routerEngine->setStaticAssetsRouteHandler($handler);
    }

    /**
     * Set default middleware method's name.
     *
     * @param string $method
     * @return void
     */
    public function setDefaultMiddlewareMethodName($method)
    {
        return $this->routerEngine->setDefaultMiddlewareMethodName($method);
    }

    /**
     * Start the router execution.
     *
     * @return void
     */
    public function start()
    {
        if (config('app.allow_http_method_override')) {
            $this->routerEngine->enableHttpMethodOverride();
        }

        $this->routerEngine->setActionRunner(CoreActionRunner::class);

        $this->routerEngine->run();
    }
}
