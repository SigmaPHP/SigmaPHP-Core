<?php

if (!function_exists('version')) {
    /**
     * Get the version of the installed framework.
     *
     * @return string
     */
    function version() {
        return \SigmaPHP\Core\App\Kernel::SIGMAPHP_FRAMEWORK_VERSION;
    }
}

if (!function_exists('container')) {
    /**
     * Get the DI Container instance.
     *
     * @return \SigmaPHP\Container\Container
     */
    function container($item = '') {
        $container = \SigmaPHP\Core\App\Kernel::getContainer();
        return empty($item) ? $container : $container->get($item);
    }
}

if (!function_exists('env')) {
    /**
     * Return value of environment variable.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function env($key, $default = '') {
        new \SigmaPHP\Core\App\Kernel();
        return $_ENV[$key] ?? $default;
    }
}

if (!function_exists('config')) {
    /**
     * Return value of a config.
     *
     * @param string $key
     * @param mixed $default
     * @return mixed
     */
    function config($key, $default = '') {
        return container('config')->get($key, $default);
    }
}

if (!function_exists('root_path')) {
    /**
     * Return the full path of a directory.
     *
     * @return string
     */
    function root_path($dir) {
        return container('config')::getFullPath($dir);
    }
}

if (!function_exists('url')) {
    /**
     * Generate URL from route's name.
     *
     * @param string $routeName
     * @param array $parameters
     * @return string
     */
    function url($routeName, $parameters = []) {
        return container('router')->url($routeName, $parameters);
    }
}

if (!function_exists('baseUrl')) {
    /**
     * Get base URL.
     *
     * @return string
     */
    function baseUrl() {
        return container('router')->getBaseUrl();
    }
}

if (!function_exists('encrypt')) {
    /**
     * Encrypt text.
     *
     * @param string $text
     * @param string $salt
     * @return string
     */
    function encrypt($text, $salt = '') {
        return openssl_encrypt(
            $text,
            'aes128',
            env('APP_SECRET_KEY'),
            0,
            !empty($salt) ?
                $salt :
                substr(hash('sha256', env('APP_SECRET_KEY')), 0, 16)
        );
    }
}

if (!function_exists('decrypt')) {
    /**
     * Decrypt text.
     *
     * @param string $text
     * @param string $salt
     * @return string
     */
    function decrypt($text, $salt = '') {
        return openssl_decrypt(
            $text,
            'aes128',
            env('APP_SECRET_KEY'),
            0,
            !empty($salt) ?
                $salt :
                substr(hash('sha256', env('APP_SECRET_KEY')), 0, 16)
        );
    }
}

if (!function_exists('shareTemplateVariable')) {
    /**
     * Register new shared template's variable.
     *
     * @param array $variables
     * @return void
     */
    function shareTemplateVariable($variables) {
        $currentSharedTemplateVars = container('shared_template_variables');

        container()->set('shared_template_variables', array_merge(
            $currentSharedTemplateVars,
            $variables
        ));
    }
}

if (!function_exists('defineCustomTemplateDirective')) {
    /**
     * Register new template's custom directive.
     *
     * @param callable $callback
     * @return void
     */
    function defineCustomTemplateDirective($name, $callback) {
        $currentCustomDirectives = container('custom_template_directives');

        container()->set('custom_template_directives', array_merge(
            $currentCustomDirectives,
            [$name => $callback]
        ));
    }
}
