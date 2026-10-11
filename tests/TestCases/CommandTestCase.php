<?php

namespace SigmaPHP\Core\Tests\TestCases;

use PHPUnit\Framework\TestCase;
use SigmaPHP\Console\Command;
use SigmaPHP\Console\Interfaces\CommandInterface;
use SigmaPHP\Console\IO;

/**
 * Command Test Case
 */
class CommandTestCase extends TestCase
{
    /**
     * @var IO $ioHandler
     */
    protected $ioHandler;

    /**
     * CommandTestCase SetUp
     *
     * @return void
     */
    public function setUp(): void
    {
        $this->ioHandler = new IO();
        $this->ioHandler->setOutputStream(fopen('php://memory', 'w+'));

        if (!file_exists('fake_input_stream')) {
            touch('fake_input_stream');

            $this->ioHandler->setInputStream(fopen('fake_input_stream', 'r+'));
        }
    }

    /**
     * CommandTestCase TearDown
     *
     * @return void
     */
    public function tearDown(): void
    {
        if (file_exists('fake_input_stream')) {
            unlink('fake_input_stream');
        }
    }

    /**
     * Command factory.
     *
     * @param Command $class
     * @return CommandInterface
     */
    protected function commandFactory($class)
    {
        $command = new $class();

        $command->setIOHandler($this->ioHandler);

        return $command;
    }

    /**
     * Inject input into a stream.
     *
     * @param string $input
     * @return void
     */
    protected function injectInput($input)
    {
        $res = fopen('fake_input_stream', 'r+');

        ftruncate($res, 0);
        rewind($res);
        fwrite($res, $input);
        rewind($res);
    }
}
