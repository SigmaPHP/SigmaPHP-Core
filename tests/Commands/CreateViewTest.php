<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateView;

/**
 * Create View Command Test
 */
class CreateViewTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'templates/users_table.template.html';
        $command = new _CreateView();

        $command->setIOHandler($this->ioHandler);

        $command->_arguments()['name']->setValue('users_table');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}

class _CreateView extends CreateView
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
