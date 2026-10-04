<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateController;

/**
 * Create Controller Command Test
 */
class CreateControllerTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'controllers/UserController.php';
        $command = new _CreateController();

        $command->setIOHandler($this->ioHandler);

        $command->_arguments()['name']->setValue('User');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}

class _CreateController extends CreateController
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
