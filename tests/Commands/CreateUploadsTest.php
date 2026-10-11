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
        $command = $this->commandFactory(CreateUploads::class);

        $command->execute();

        $this->assertTrue(file_exists('uploads'));
        $this->assertTrue(file_exists('public/uploads'));
    }
}
