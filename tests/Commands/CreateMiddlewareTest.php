<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateMiddleware;

/**
 * Create Middleware Command Test
 */
class CreateMiddlewareTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'middlewares/AuthMiddleware.php';
        $command = new _CreateMiddleware();

        $command->setIOHandler($this->ioHandler);

        $command->_arguments()['name']->setValue('Auth');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}

class _CreateMiddleware extends CreateMiddleware
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
