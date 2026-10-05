<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateCommand;

/**
 * Create 'Custom Command' Command Test
 */
class CreateCommandTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'commands/FormatCommand.php';
        $command = new _CreateCommand();

        $command->setIOHandler($this->ioHandler);

        $command->_arguments()['name']->setValue('Format');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}

class _CreateCommand extends CreateCommand
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
