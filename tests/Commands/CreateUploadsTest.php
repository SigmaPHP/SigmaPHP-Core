<?php

use SigmaPHP\Core\Tests\TestCases\CommandTestCase;
use SigmaPHP\Core\Commands\CreateUploads;

/**
 * Create Uploads Command Test
 */
class CreateUploadsTest extends CommandTestCase
{
    /**
     * Test command execution.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testCommandExecution()
    {
        $command = new _CreateUploads();

        $command->setIOHandler($this->ioHandler);

        $command->execute();

        $this->assertTrue(file_exists('uploads'));
        $this->assertTrue(file_exists('public/uploads'));
    }
}

class _CreateUploads extends CreateUploads
{
    public function _options() {return $this->options;}
    public function _arguments() {return $this->arguments;}
}
