<?php

namespace SigmaPHP\Core\Config;

use SigmaPHP\Core\Interfaces\Config\ConfigInterface;
use SigmaPHP\Collections\Collection;

/**
 * Config Class
 */
class Config extends Collection implements ConfigInterface
{
    /**
     * Config Constructor
     */
    public function __construct()
    {
        parent::__construct($this->load());
    }

    /**
     * Get full path for file/folder , relevant to
     * the framework base path (outside vendor).
     *
     * @param string $dis
     * @return string
     */
    public static function getFullPath($dis)
    {
        $basePath = dirname(
            (new \ReflectionClass(
                \Composer\Autoload\ClassLoader::class
            ))->getFileName()
        , 3);

        return $basePath . '/' . $dis;
    }

    /**
     * Load all config files.
     *
     * @return array
     */
    public function load()
    {
        $configs = [];

        $path = self::getFullPath('config');

        if ($handle = opendir($path)) {
            while (($file = readdir($handle))) {
                if (in_array($file, ['.', '..'])) continue;
                $configs[str_replace('.php', '', $file)] =
                    require $path . '/' . $file;
            }

            closedir($handle);
        }

        return $configs;
    }

    /**
     * Get config value , and support dot notation.
     *
     * @param string $key
     * @param string $default
     * @return mixed
     */
    public function get($key, $default = '')
    {
        $value = $this->items;

        foreach (explode('.', $key) as $option) {
            $value = $value[$option] ?? null;
        }

        return $value ?? $default;
    }

    /**
     * Set config value.
     *
     * @param string $key
     * @param mixed $val
     * @return $this
     */
    public function set($key, $val)
    {
        $arr = &$this->items;

        foreach (explode('.', $key) as $option) {
            if (!array_key_exists($option, $arr)) {
                $arr[$option] = [];
            }

            $arr = &$arr[$option];
        }

        $arr = $val;

        return $this;
    }

    /**
     * Check if config value exists.
     *
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $value = $this->items;

        foreach (explode('.', $key) as $option) {
            if (!array_key_exists($option, $value)) {
                return false;
            }

            $value = $value[$option];
        }

        return true;
    }

    /**
     * Set errors display.
     *
     * @param string $env
     * @return bool
     */
    public function setErrorsDisplay($env)
    {
        ini_set('display_errors', ($env != 'production'));
        ini_set('display_startup_errors', ($env != 'production'));
        error_reporting(($env == 'production')? 0 : E_ALL);
    }

    /**
     * Set timezone.
     *
     * @param string $timezoneId
     * @return bool
     */
    public function setTimezone($timezoneId)
    {
        return date_default_timezone_set($timezoneId);
    }
}
