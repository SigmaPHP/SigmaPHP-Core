<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
use SigmaPHP\Console\Option;
use SigmaPHP\Filesystem\Filesystem;

/**
 * Core Base Command.
 */
abstract class CoreCommand extends Command
{
    /**
     * @var Filesystem $filesystem
     */
    protected $filesystem;

    /**
     * Core Base Command Constructor.
     *
     * @param array<Option> $options
     * @param array<string> $shortcuts
     */
    public function __construct($options = [], $shortcuts = [])
    {
        parent::__construct($options, $shortcuts);

        $this->filesystem = new Filesystem();
    }

    /**
     * Initialize the command.
     *
     * @return void
     */
    abstract public function init();

    /**
     * Execute.
     *
     * @return void
     */
    abstract public function execute();

    /**
     * Create a class of a specific type.
     *
     * @param string $classPath
     * @param string $type
     * @param string $name
     * @param bool $noContent
     * @param bool $noSlug
     * @param string $extension
     * @param string $register
     * @return void
     */
    public function createClass(
        $classPath,
        $type,
        $name,
        $noContent = false,
        $noSlug = false,
        $extension = 'php',
        $register = '',
    ) {
        // first we get the full path to be created if doesn't exists
        // we handle also the case where the path contains lowercase
        // like "/foo/bar" it should be "/Foo/Bar" !!
        $path = rootPath($classPath);

        if (strpos($name, DIRECTORY_SEPARATOR) !== false) {
            $path = $this->filesystem->concatPath(
                rootPath($classPath),
                ucwords($this->filesystem->getPath($name), DIRECTORY_SEPARATOR)
            );
        }

        if (!$this->filesystem->exists($path)) {
            $this->filesystem->createDir($path);
        }

        // remove the path from the file name if exists
        // and capitalize first letter
        $name = $noSlug ?
            $this->filesystem->getFileName($name) :
            ucfirst($this->filesystem->getFileName($name));

        // add the type automatically if the name doesn't have it
        // also, handle types with spaces, like 'service provider'
        if (!$noSlug &&
            (stripos($name, str_replace(' ', '', ucwords($type))) === false)
        ) {
            $name .= str_replace(' ', '', ucwords($type));
        }

        $classFile = concatPath(rtrim($path, DIRECTORY_SEPARATOR), $name)
            . '.' . $extension;

        if ($this->filesystem->exists($classFile)) {
            $this->info(
                "The {$type} '{$name}' already exists"
            );

            return;
        }

        $namespace = createNamespace(trim(str_replace(rootPath(), '', $path), DIRECTORY_SEPARATOR));

        $content = $noContent ? '' : str_replace(
            ['$className', '$namespace'],
            [$name, $namespace],
            $this->filesystem->read(
                concatPath(
                    __DIR__,
                    'templates',
                    str_replace(' ', '_', $type) . '.php.dist'
                )
            )
        );

        $this->filesystem->create($classFile, $content);

        // register class in config
        if (!empty($register)) {
            $list = $this->filesystem->read($register);

            // we just add the full class path before the ']'
            $list = str_replace(
                ']',
                "    \\$namespace\\" . $name . "::class,\n]",
                $list
            );

            $this->filesystem->write($register, $list);
        }

        $this->success(
            "The {$type} '{$name}' was created successfully"
        );
    }
}
