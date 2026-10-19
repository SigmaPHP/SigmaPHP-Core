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

        $this->assertTrue(file_exists('public/uploads'));

        // clean the miss and recreate the uploads
        if (file_exists('public/uploads')) {
            unlink('public/uploads');
        }
    }

    /**
     * Test uploads won't be created if already exists.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testUploadsWillNotBeCreatedIfAlreadyExists()
    {
        $targetPath = 'public/uploads';

        if (!file_exists($targetPath)) {
            touch($targetPath);
        }

        $this->ioHandler->setOutputStream(fopen('php://output', 'r+'));

        $command = $this->commandFactory(CreateUploads::class);

        $command->execute();

        $this->expectOutputRegex(
            "/The uploads directory already exists/"
        );

        if (file_exists($targetPath)) {
            unlink($targetPath);
        }
    }
}
