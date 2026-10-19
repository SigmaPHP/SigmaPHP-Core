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

        $command = $this->commandFactory(CreateMiddleware::class);

        $command->getArguments()['name']->setValue('Auth');

        $command->execute();

        $this->assertTrue(file_exists($targetPath));
    }

    /**
     * Test middleware won't be created if already exists.
     *
     * @runInSeparateProcess
     * @return void
     */
    public function testMiddlewareWillNotBeCreatedIfAlreadyExists()
    {
        $targetPath = 'middlewares/AuthMiddleware.php';

        if (!file_exists($targetPath)) {
            touch($targetPath);
        }

        $this->ioHandler->setOutputStream(fopen('php://output', 'r+'));

        $command = $this->commandFactory(CreateMiddleware::class);

        $command->getArguments()['name']->setValue('Auth');

        $command->execute();

        $this->expectOutputRegex(
            "/The middleware 'AuthMiddleware' already exists/"
        );

        if (file_exists($targetPath)) {
            unlink($targetPath);
        }
    }
}
