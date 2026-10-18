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
}
