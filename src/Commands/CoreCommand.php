<?php

namespace SigmaPHP\Core\Commands;

use SigmaPHP\Console\Command;
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
     */
    public function __construct() {
        parent::__construct();

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
