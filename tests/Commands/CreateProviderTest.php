<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateProvider;

/**
 * Create Provider Command Test
 */
class CreateProviderTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $targetPath = 'providers/UserServiceProvider.php';
        $command = new _CreateProvider();

        $command->setIOHandler($this->ioHandler);

        $command->_arguments()['name']->setValue('User');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }
}

class _CreateProvider extends CreateProvider
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
